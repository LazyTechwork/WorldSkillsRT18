<div class='wpcf_nd_wraper'>
    <center>

        <h1 style="font-weight: 300; font-size: 50px; line-height: 50px;">
            <?php _e("Welcome to Contact Form Ready!",'wpcf_nd'); ?> 
        </h1>
        <div class="about-text" style="margin: 15px; font-size:26px; font-style:italic;"><?php _e("Contact Form Ready is the easiest to use drag and drop contact form builder, with amazing features.","sola"); ?></div>
        <hr />
        <h2 style="font-size: 25px;"><?php _e("How did you find us?","sola"); ?></h2>
        <form method="post" name="wpcf_nd_find_us_form" style="font-size: 16px;">
            <div  style="text-align: left; width:275px;">
                <input type="radio" name="wpcf_nd_find_us" id="wordpress" value='repository'>
                <label for="wordpress">
                    <?php _e('WordPress.org plugin repository ', 'wpcf_nd'); ?>
                </label>
                <br/>
                <input type='text' placeholder="<?php _e('Search Term', 'wpcf_nd'); ?>" name='wpcf_nd_nl_search_term' style='margin-top:5px; margin-left: 23px; width: 100%  '>
                <br/>
                <input type="radio" name="wpcf_nd_find_us" id="search_engine" value='search_engine'>
                <label for="search_engine">
                    <?php _e('Google or other search Engine', 'wpcf_nd'); ?>
                </label>
                <br/>
                <input type="radio" name="wpcf_nd_find_us" id="friend" value='friend'>
                
                <label for='friend'>
                    <?php _e('Friend recommendation', 'wpcf_nd'); ?>
                </label>
                <br/>   
                <input type="radio" name="wpcf_nd_find_us" id='other' value='other'>
                
                <label for='other'>
                    <?php _e('Other', 'wpcf_nd'); ?>
                </label>
                <br/>
                
                <textarea placeholder="<?php _e('Please Explain', 'wpcf_nd'); ?>" style='margin-top:5px; margin-left: 23px; width: 100%' name='wpcf_nd_nl_findus_other_url'></textarea>
            </div>
            <div>
                
            </div>
            <div>
                
            </div>
            <div style='margin-top: 20px;'>
                <button name='action' value='wpcf_nd_submit_find_us' class="button-primary" style="font-size: 30px; line-height: 60px; height: 60px; margin-bottom: 10px;"><?php _e('Submit', 'wpcf_nd'); ?></button>
                <br/>
                <button name='action' value="wpcf_nd_skip_find_us" class="button"><?php _e('Skip', 'wpcf_nd'); ?></button>
            </div>
        </form> 
    </center>
</div>

