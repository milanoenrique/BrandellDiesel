<?php if (isset($data['group'])): ?>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="<?php echo $_icon; ?>" aria-hidden="true"></i><?php echo $key; ?>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($data['group'] as $groupkey => $groupvalue): ?>
                <?php  echo classHeader::buildMenu($groupvalue,$groupkey); ?>
            <?php endforeach; ?>
        </ul>
    </li>

<?php else: ?>

    <li>
        <a <?php echo $_id; ?> href="<?php echo $_url; ?>" class="<?php echo isset($data['class'])?$data['class']:''; ?>">
            <i class="<?php echo $_icon; ?>" aria-hidden="true"></i>
            <?php echo $key; ?>
        </a>
    </li>

<?php endif; ?>