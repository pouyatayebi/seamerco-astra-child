<?php
defined('ABSPATH') || exit ("no access");
if( empty($this->cf54f8cc4645512e25da78e8c) ): ?>
    <div class="notice notice-error">
        <?php if (version_compare(PHP_VERSION, '7.0.0') >= 0):?>
        <p>
            <?php printf(esc_html__( 'To activating %s, please insert your license key', 'guard-gn-d14bcc3afcede4dfeb3c54391d5ce65a' ), esc_html__($this->d7529cfbc471ff4c3a3cafdfa3d, 'guard-gn-d14bcc3afcede4dfeb3c54391d5ce65a')); ?>
            <a href="<?php echo admin_url( 'admin.php?page='.$this->e6686906d3e85d538b005b650f ); ?>" class="button button-primary"><?php _e('Active License', 'guard-gn-d14bcc3afcede4dfeb3c54391d5ce65a'); ?></a>
        </p>
        <?php else:?>
            <p>
                <?php printf(esc_html__( 'The PHP version of the website is lower than 7.0. Ask your host administrator to upgrade PHP version to activate %s. ', 'guard-gn-d14bcc3afcede4dfeb3c54391d5ce65a' ), esc_html__($this->d7529cfbc471ff4c3a3cafdfa3d, 'guard-gn-d14bcc3afcede4dfeb3c54391d5ce65a')); ?>
            </p>
    <?php endif; ?>
    </div>
<?php elseif( $this->c6d53604411f49903c97593d49711f1f===true ): ?>
    <div class="notice notice-error">
        <p>
            <?php printf(esc_html__( 'Something is wrong with your %s license. Please check it.', 'guard-gn-d14bcc3afcede4dfeb3c54391d5ce65a' ), esc_html__($this->d7529cfbc471ff4c3a3cafdfa3d, 'guard-gn-d14bcc3afcede4dfeb3c54391d5ce65a')); ?>
            <a href="<?php echo admin_url( 'admin.php?page='.$this->e6686906d3e85d538b005b650f ); ?>" class="button button-primary"><?php _e('Check Now', 'guard-gn-d14bcc3afcede4dfeb3c54391d5ce65a'); ?></a>
        </p>
    </div>
<?php endif; ?>