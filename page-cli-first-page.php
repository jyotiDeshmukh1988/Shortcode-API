<?php
get_header();
?>
<main id="site-content" role="main">
<?php
$pageID = get_the_ID();
$yourprefix_demo_text = get_post_meta($pageID,'yourprefix_demo_text',true);
echo "<strong>yourprefix_demo_text - </strong>".$yourprefix_demo_text;
echo "<br/>";
$yourprefix_demo_url = get_post_meta($pageID,'yourprefix_demo_url',true);
echo "<strong>yourprefix_demo_url - </strong>".$yourprefix_demo_url;
echo "<br/>";
$yourprefix_demo_email = get_post_meta($pageID,'yourprefix_demo_email',true);
echo "<strong>yourprefix_demo_email - </strong>".$yourprefix_demo_email;
echo "<br/>";
$yourprefix_demo_textareasmall = get_post_meta($pageID,'yourprefix_demo_textareasmall',true);
echo "<strong>yourprefix_demo_textareasmall - </strong>".$yourprefix_demo_textareasmall;
echo "<br/>";
// convert JSON string to array
$yourprefix_group_demo = get_post_meta($pageID,'yourprefix_group_demo',true);
$data = json_encode($yourprefix_group_demo);
$person = json_decode($data);
echo "Repeater Field Title :- ".$person[0]->title."<br/>";
echo "Repeater Field Description :- ".$person[0]->description."<br/>";
echo "Repeater Field Image :- " ?>
<img src="<?php echo $person[0]->image; ?>"/>;
<?php
echo "Repeater Field Image Caption :- ".$person[0]->image_caption."<br/>";
?>
</main>
<?php
get_footer();
?>