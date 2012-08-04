<?php echo $this->renderWidget('IpTitle', array('title' => $this->par('community/comments/translations/comment')), 'level3'); ?>

<?php echo (isset($form) ? $form->render() : '') ?>


<?php if(!empty($comments)) { ?>
    <?php echo $this->renderWidget('IpTitle', array('title' => $this->par('community/comments/translations/comments')), 'level3'); ?>
    <ol class="ipModuleCommunityComments">
        <?php foreach($comments as $key => $comment){ ?>
            <li id="ipComment-'.$comment['id'].'" class="<?php echo $comment['approved'] ? '' : 'notApproved' ?> <?php echo $key%2 == 0 ? 'ipModuleCommunityCommentsEven' : '' ?>">
                <cite>
                    <?php if($comment['link']){ ?>
                        <a rel="external nofollow" href="<?php echo $this->esc($comment['link']) ?>"><?echo $this->esc($comment['name']) ?></a>
                    <?php } else { ?>
                        <?echo $this->esc($comment['name']) ?>
                    <?php } ?>
                </cite>
                <?php $this->escPar('community/comments/translations/says') ?>
                <?php if(empty($comment['approved']) || $comment['approved'] != true) { ?>
                    <em><?php echo $this->escPar('community/comments/translations/awaiting_moderation') ?></em>'
                <?php } ?>
                <br/>
                <small class="commentMetaData">
                    <a href="#ipComment-'.$comment['id'].'">
                        <?php date("Y-m-d G:i", strtotime($comment['created'])) ?>
                    </a>
                </small>
                <p>
                    <?php echo $comment['text'] ? $comments['text'] : '' ?>
                </p>
            </li>
        <?php } ?>
    </ol>
<?php } ?>
