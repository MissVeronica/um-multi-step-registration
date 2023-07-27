# UM Multi Step Registration Forms
Extension to Ultimate Member for Multi Step Registration Forms. 

The plugin is inserting Sections into the large Registration form based on a "Page" UM Form field set by the Admin user in UM Forms Builder. The UM Registration page shortcode is replaced by a new shortcode activating the plugin. Plugin will display/hide each subpage depending on usage of the Page selection buttons. Registration form can be submitted from any subpage and if there are any field errors they are being displayed at the field in error on the subpage and at the bottom of each subpage.

## UM Settings
1. See screen copies at https://imgur.com/a/pkBuV7i
2. "Page" a new UM Forms Builder field for adding Page breaks in the Registration Form
3. Shortcode to use instead of the UM Registration form shortcode like <code>[ultimatemember form_id="9999"]</code>
4. with this plugin the shortcode is: <code>[um_multi_step_registration form_id="9999"]</code>
5. Make sure you have set the PHP option "max_input_vars" to a value based on your number of input fields.
6. https://docs.ultimatemember.com/article/1552-how-to-manage-profile-form-with-a-huge-quantity-of-fields

## Installation
1. Download the zip file and install as a WP Plugin, activate the plugin.
