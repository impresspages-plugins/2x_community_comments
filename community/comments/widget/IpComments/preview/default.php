<?php echo $this->renderWidget('IpTitle', array('title' => $this->par('community/comments/translations/comment')), 'level3'); ?>

<?php if(isset($form)) { ?>
    <div class="ipWidget">
        <?php echo $form->render() ?>
    </div>
<?php } ?>

<?php if(!empty($comments)) { ?>
    <?php echo $this->renderWidget('IpTitle', array('title' => $this->par('community/comments/translations/comments')), 'level3'); ?>
    <ul class="ipmComments">
        <?php foreach($comments as $key => $comment){ ?>
            <li class="ipmComment-<?php echo isset($comment['id']) ? $comment['id'] : '' ?> <?php echo $comment['approved'] ? '' : 'ipmNotApproved' ?> <?php echo $key%2 == 0 ? 'ipmEven' : '' ?>">
                <cite><a name="ipModuleComments-<?php echo isset($comment['id']) ? $comment['id'] : '' ?>" href="#ipModuleComments-<?php echo isset($comment['id']) ? $comment['id'] : '' ?>"></a>
                    <?php if($comment['link']){ ?>
                        <a rel="external nofollow" href="<?php echo $this->esc($comment['link']) ?>">
                            <?echo $this->esc($comment['name']) ?>
                        </a>
                    <?php } else { ?>
                        <?echo $this->esc($comment['name']) ?>
                    <?php } ?>
                </cite>
                <?php $this->escPar('community/comments/translations/says') ?>
                <?php if(empty($comment['approved']) || $comment['approved'] != true) { ?>
                    <em><?php echo $this->escPar('community/comments/translations/awaiting_moderation') ?></em>
                <?php } ?>
                <br/>
                <small class="ipmMetaData">
                    <?php echo date("Y-m-d G:i", strtotime($comment['created'])) ?>
                </small>
                <p>
                    <?php echo isset($comment['text']) ? $comment['text'] : '' ?>
                </p>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
