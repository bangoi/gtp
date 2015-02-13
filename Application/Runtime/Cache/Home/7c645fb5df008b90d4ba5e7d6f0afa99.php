<?php if (!defined('THINK_PATH')) exit();?><li id="comment-<?php echo ($comment["id"]); ?>">
    <div class="comm_l">
        <a href="http://localhost:9990/gtp/user/<?php get_user_domain($comment['user_id']) ?>"><img src="<?php get_user_face($comment['user_id']); ?>" class="face" /></a>
    </div>
    <div class="comm_r">
        <a href="http://localhost:9990/gtp/user/<?php get_user_domain($comment['user_id']) ?>" id="comm-nick-<?php echo ($comment["id"]); ?>"><?php echo ($comment["nick"]); ?></a> &nbsp; <span class="c7"><?php echo (firendlytime($comment["add_time"])); ?></span>
        <?php if(!empty($comment['parent_id']) && $comment['parent_id'] > 0) { ?>
        <p class="quote_item"><?php get_parent_user($comment['parent_id']); ?>：<br/><?php get_parent_comment($comment['parent_id']); ?></p>
        <?php } ?>
        <p id="comm-cnt-<?php echo ($comment["id"]); ?>"><?php echo (autolink($comment["content"])); ?></p>
    </div>
    <div class="c_opt">
        <?php if(is_topic_owner($item_id, $_uid) || is_comment_owner($comment['id'], $_uid)) { ?>
        <a href="javascript:void(0);" class="doDelete" cid="<?php echo ($comment["id"]); ?>">删除</a> &nbsp;
        <?php } ?>
        <a href="javascript:void(0);" class="doQuote" cid="<?php echo ($comment["id"]); ?>">回应</a>
    </div>
    <br class="clear" />
</li>