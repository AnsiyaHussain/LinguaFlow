</main><!-- /.lf-main-content -->

<footer class="lf-footer" style="background: var(--lf-black); color: var(--lf-text-light); padding: 4rem 0 3rem; margin-top: 5rem; border-top: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="lf-container">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 2rem; margin-bottom: 3rem;">
            <div style="max-width: 320px;">
                <div style="font-weight: 700; font-size: 1.4rem; letter-spacing: -0.03em; margin-bottom: 0.75rem;">LINGUAFLOW</div>
                <p style="color: var(--lf-greige); font-size: 0.9rem;">Speak. Understand. Connect. — Minimal luxury translation & voice intelligence platform.</p>
            </div>
            <div style="display: flex; gap: 3rem; flex-wrap: wrap;">
                <div>
                    <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--lf-greige); margin-bottom: 1rem;">Navigation</div>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.9rem;">
                        <li><a href="<?php echo esc_url(home_url('/translate')); ?>" style="color: #FFFFFF;">Translator</a></li>
                        <li><a href="<?php echo esc_url(home_url('/conversation')); ?>" style="color: #FFFFFF;">Conversation Mode</a></li>
                        <li><a href="<?php echo esc_url(home_url('/practice')); ?>" style="color: #FFFFFF;">Pronunciation Coach</a></li>
                    </ul>
                </div>
                <div>
                    <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--lf-greige); margin-bottom: 1rem;">Platform</div>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.9rem;">
                        <li><a href="<?php echo esc_url(home_url('/travel')); ?>" style="color: #FFFFFF;">Travel Phrase Packs</a></li>
                        <li><a href="<?php echo esc_url(home_url('/learn')); ?>" style="color: #FFFFFF;">Language Lessons</a></li>
                        <li><a href="<?php echo esc_url(home_url('/dashboard')); ?>" style="color: #FFFFFF;">Saved Notebook</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div style="border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 1.75rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; font-size: 0.8rem; color: var(--lf-greige);">
            <div>&copy; <?php echo date('Y'); ?> LinguaFlow Platform. Built with WordPress & Web Speech Engine.</div>
            <div>Minimal Luxury / Warm Neutral / SaaS Architecture</div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
