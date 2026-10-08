/**
 * LinguaFlow - MediaRecorder API & Canvas Audio Waveform Visualizer
 */

window.LinguaFlow = window.LinguaFlow || {};

(function(LF) {
    'use strict';

    class AudioStudioRecorder {
        constructor() {
            this.mediaRecorder = null;
            this.audioChunks = [];
            this.audioBlob = null;
            this.audioUrl = null;
            this.isRecording = false;
            this.audioContext = null;
            this.analyser = null;
            this.animationFrame = null;
        }

        async startRecording(canvasElement = null) {
            this.audioChunks = [];
            this.audioBlob = null;

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                LF.toast('Audio recording is not supported on this device/browser.', 'warning');
                return false;
            }

            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                this.mediaRecorder = new MediaRecorder(stream);

                this.mediaRecorder.ondataavailable = (event) => {
                    if (event.data.size > 0) {
                        this.audioChunks.push(event.data);
                    }
                };

                this.mediaRecorder.onstop = () => {
                    this.audioBlob = new Blob(this.audioChunks, { type: 'audio/webm' });
                    this.audioUrl = URL.createObjectURL(this.audioBlob);
                    this.stopVisualizer();
                };

                this.mediaRecorder.start();
                this.isRecording = true;

                if (canvasElement) {
                    this.startVisualizer(stream, canvasElement);
                }

                return true;
            } catch (err) {
                console.error('Microphone access denied or error:', err);
                LF.toast('Microphone access denied. Please grant permission.', 'warning');
                return false;
            }
        }

        stopRecording() {
            if (this.mediaRecorder && this.isRecording) {
                this.mediaRecorder.stop();
                this.mediaRecorder.stream.getTracks().forEach(track => track.stop());
                this.isRecording = false;
                this.stopVisualizer();
            }
        }

        startVisualizer(stream, canvas) {
            try {
                this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
                if (this.audioContext.state === 'suspended') {
                    this.audioContext.resume();
                }
                const source = this.audioContext.createMediaStreamSource(stream);
                this.analyser = this.audioContext.createAnalyser();
                this.analyser.fftSize = 64;
                source.connect(this.analyser);

                const ctx = canvas.getContext('2d');
                const bufferLength = this.analyser.frequencyBinCount;
                const dataArray = new Uint8Array(bufferLength);

                const draw = () => {
                    if (!this.isRecording) return;
                    this.animationFrame = requestAnimationFrame(draw);

                    this.analyser.getByteFrequencyData(dataArray);

                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    const barWidth = (canvas.width / bufferLength) * 2;
                    let barHeight;
                    let x = 0;

                    for (let i = 0; i < bufferLength; i++) {
                        barHeight = (dataArray[i] / 255) * canvas.height;

                        ctx.fillStyle = '#141413';
                        ctx.fillRect(x, (canvas.height - barHeight) / 2, barWidth - 2, barHeight);

                        x += barWidth;
                    }
                };

                draw();
            } catch (err) {
                console.warn('Audio visualizer failed to initialize:', err);
            }
        }

        stopVisualizer() {
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
            }
            if (this.audioContext && this.audioContext.state !== 'closed') {
                this.audioContext.close();
            }
        }

        playRecording() {
            if (this.audioUrl) {
                const audio = new Audio(this.audioUrl);
                audio.play().then(() => {
                    LF.toast('Playing back recorded voice...', 'info');
                }).catch((err) => {
                    console.warn('Playback error:', err);
                    LF.toast('Unable to play recording.', 'warning');
                });
                return true;
            } else {
                LF.toast('No recorded voice available to play yet.', 'info');
                return false;
            }
        }
    }

    LF.AudioStudioRecorder = new AudioStudioRecorder();

})(window.LinguaFlow);
