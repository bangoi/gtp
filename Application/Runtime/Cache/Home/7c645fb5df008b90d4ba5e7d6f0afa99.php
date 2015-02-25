<?php if (!defined('THINK_PATH')) exit();?><li id="comment-<?php echo ($comment["id"]); ?>">
    <div class="comm_l">
        <a href="http://localhost:9990/gtp/user/<?php getUserDomainById($comment['user_id']) ?>"><img src="<?php getUserFaceById($comment['user_id']); ?>" class="face" /></a>
    </div>
    <div class="comm_r">
        <a href="http://localhost:9990/gtp/user/<?php getUserDomainById($comment['user_id']) ?>" id="comm-nick-<?php echo ($comment["id"]); ?>"><?php echo ($comment["nick"]); ?></a> &nbsp; <span class="c7"><?php echo (firendlytime($comment["add_time"])); ?></span>
        <?php if(!empty($comment['parent_id']) && $comment['parent_id'] > 0) { ?>
        <?php $p_comment = getCommentById($comment['parent_id']); ?>
        <?php if(empty($p_comment) || $p_comment["state"] == -1) { ?>
            <p class="quote_item" style="color: #999;">该评论已被删除</p>
        <?php } else { ?>
            <p class="quote_item"><?php getParentUser($comment['parent_id']); ?>：<?php echo $p_comment['content']; ?></p>
        <?php } ?>
        <?php } ?>
        <p id="comm-cnt-<?php echo ($comment["id"]); ?>"><?php echo (autolink($comment["content"])); ?></p>
    </div>
    <div class="c_opt">
        <?php if(isTopicOwnerById($item_id, $_uid) || isCommentOwner($comment['id'], $_uid)) { ?>
        <a href="javascript:void(0);" class="doDelete" cid="<?php echo ($comment["id"]); ?>">删除</a> &nbsp;
        <?php } ?>
        <a href="javascript:void(0);" class="doQuote" cid="<?php echo ($comment["id"]); ?>">回应</a>
    </div>
    <br class="clear" />
</li>