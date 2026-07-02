<?php

if (!defined('ABSPATH')) {
    exit;
}

?>

<div style="width:100%; display:flex; flex-direction: column; gap: 10px;">
    <p><?php echo esc_html($data['name'] ?? ''); ?></p>
    <p><?php echo esc_html($data['email'] ?? ''); ?></p>
    <img src="<?php echo esc_url($data['avatar'] ?? ''); ?>" alt="<?php echo esc_attr($data['name'] ?? ''); ?>">
</div>
    
