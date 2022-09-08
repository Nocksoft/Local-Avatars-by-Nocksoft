<?php

add_action("admin_menu", "nstla_settings_page");
function nstla_settings_page() {
    add_submenu_page(
        "options-general.php",
        "Local Avatars by Nocksoft",
        "Local Avatars",
        "manage_options",
        "nstla",
        "nstla_globalsettings"
    );
}


add_action("admin_init", function() {
	register_setting("nstla_settings_general", "nstla_setting_redirectgravatar_all", "boolval");
	register_setting("nstla_settings_general", "nstla_setting_localavatar_default");
});



function nstla_globalsettings() {
    if (!current_user_can("manage_options")) return;

	global $nstla_setting_redirectgravatar_all;
	global $nstla_setting_localavatar_default;
	
	$tab = isset($_GET["tab"]) ? sanitize_text_field($_GET["tab"]) : null;
    ?>
    <div class="wrap">
        <h1><?php echo get_admin_page_title(); ?></h1>
		
		<p><?php echo __("User-specific settings are made in your user profile in WordPress (Users -> Your Profile -> Edit). General settings can be made here.", "local-avatars-by-nocksoft"); ?></p>
		
		<nav class="nav-tab-wrapper">
			<a href="?page=nstla" class="nav-tab<?php if ($tab == "general" || $tab == null) echo " nav-tab-active"; ?>"><?php echo __("General", "local-avatars-by-nocksoft"); ?></a>
		</nav>
		
        <form action="options.php" method="post">
            <?php
			$option_group = null;
			if ($tab == "general" || $tab == null) $option_group = "nstla_settings_general";
			else return;
            settings_fields($option_group);
            do_settings_sections("nstla");
            ?>

			<div class="tab-content">
				<?php
				if ($tab == "general" || $tab == null) {
					?>
					<table class="form-table">
						<tr valign="top">
						<th scope="row"><?php echo __("Gravatar", "local-avatars-by-nocksoft"); ?></th>
						<td>
							<input type="checkbox" id="nstla_setting_redirectgravatar_all" name="nstla_setting_redirectgravatar_all" <?php checked($nstla_setting_redirectgravatar_all); ?> />
							<label for="nstla_setting_redirectgravatar_all"><?php echo __("Redirect all Gravatar requests to local avatars (choose default avatar below)", "local-avatars-by-nocksoft"); ?></label>
							
							<?php
								$pingu = plugin_dir_url(__DIR__) . "img/local-avatar-pingu.png";
								$mystery = plugin_dir_url(__DIR__) . "img/local-avatar-mystery.png";
							?>
							<p class="defaultavatarpicker">
								<input type="radio" name="nstla_setting_localavatar_default" value="pingu" <?php checked($nstla_setting_localavatar_default, "pingu"); ?> /><img id="nstla_avatar" class="avatar" width="48" height="48" src="<?php echo esc_url($pingu); ?>"><br>
								<input type="radio" name="nstla_setting_localavatar_default" value="mystery" <?php checked($nstla_setting_localavatar_default, "mystery"); ?> /><img id="nstla_avatar" class="avatar" width="48" height="48" src="<?php echo esc_url($mystery); ?>">
							</p>
						</td>
						</tr>
					</table>
					<?php
				}
			?>
			</div>


            <?php submit_button(__("Save Settings", "local-avatars-by-nocksoft")); ?>
        </form>
    </div>
    <?php
}

?>