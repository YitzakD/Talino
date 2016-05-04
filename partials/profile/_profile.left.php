<span class="p-user-avatar moy-raduised">
    <a href="settings.php?page=profile&id=<?= get_session('pseudo'); ?>" class="moy-raduised" alt="Changer mon image de profile">
        <img src="<?= $user->avatar != '' ? set_avatar(e($user->id)) : get_avatar(); ?>"
             alt="<?= e($user->pseudo); ?>"
             class="moy-raduised" />
    </a>
</span>

<span class="p-user-name">
    <?= $user->name ? e($user->name) : ""; ?>
    <span class="p-u-pseudo-faded"><?=  e($user->pseudo); ?></span>
</span>

<span class="divider float-left"></span>

<span class="p-user-about">

    <?php if($user->sex): ?>
    <span class="span-horizontal-group">
        <?= $user->sex === 'F'
            ? '<span class="span-in-left"><i class="fa fa-female"></i></span><span class="span-in-right">Femme</span>'
            : '<span class="span-in-left"><i class="fa fa-male"></i></span><span class="span-in-right">Homme</span>' ;
        ?>
    </span>
    <?php endif; ?>

    <?php if($user->city && $user->country): ?>
    <span class="span-horizontal-group">
        <?= $user->city  && $user->country
            ? '<span class="span-in-left"><i class="fa fa-location-arrow"></i></span>'
            . '<span class="span-in-right">'.e($user->city).' - ('.e($user->country).')'
            . '<br />'
            . '<a class="btn-link" target="_blank" href="//google.com/maps?q='.e($user->city).'&nbsp;'.e($user->country).'">Voir sur une carte</a>'
            : '';
        ?>
        </span>
    </span>
    <?php endif; ?>

    <?php if($user->status === "Public"): ?>
    <span class="span-horizontal-group">
        <?= $user->email
            ? '<span class="span-in-left"><i class="fa fa-envelope"></i></span>'
            . '<span class="span-in-right"><a href="mailto:'.e($user->email).'" class="btn-link">'.e($user->email).'</a></span>'
            : '';
        ?>
    </span>
    <?php endif; ?>

    <?php if($user->facebook): ?>
    <span class="span-horizontal-group">
        <?= $user->facebook
            ? '<span class="span-in-left"><i class="fa fa-facebook"></i></span>'
            . '<span class="span-in-right"><a href="facebook.com'.e($user->facebook).'" target="_blank" class="btn-link">'.e($user->facebook).'</a></span>'
            : '';
        ?>
    </span>
    <?php endif; ?>

    <?php if($user->twitter): ?>
    <span class="span-horizontal-group">
         <?= $user->twitter
             ? '<span class="span-in-left"><i class="fa fa-twitter"></i></span>'
             . '<span class="span-in-right"><a href="twitter.com'.e($user->twitter).'" target="_blank" class="btn-link">'.e($user->twitter).'</a></span>'
             : '';
         ?>
    </span>
    <?php endif; ?>

    <?php if($user->bio): ?>
    <span class="span-horizontal-group">
         <?= $user->bio
             ? '<span class="span-in-left"><i class="fa fa-paragraph"></i></span>'
             . '<span class="span-in-right p-u-bio">'.e(read_more($user->bio, 10)).'...</span>'
             : '';
         ?>
    </span>
    <?php endif; ?>

    <?php if($user->bio == "" && $user->city == "" && $user->country == ""): ?>
    <span class="span-horizontal-group">
        <div class="alert alert-info set-alert-in-block text-in-shadowed" style="font-size: 13px;">
            <i class="fa fa-info"></i>&nbsp;Pensez à mettre votre page de <a href="settings.php?page=profile" class="btn-link blanco underlined">profile</a> à jour!
        </div>
    </span>
    <?php endif; ?>

</span>

<span class="divider float-left"></span>

<span class="p-user-associates">

    <span class="span-vertical-group">
        <span class="span-in-top bolder nbr-in-color">0</span>
        <span class="span-in-bottom fields-in-pu"><i class="fa fa-users"></i>&nbsp;Ami(e)s</span>
    </span>

    <span class="span-vertical-group">
        <span class="span-in-top bolder nbr-in-color"><?= $nboard; ?></span>
        <span class="span-in-bottom fields-in-pu"><i class="fa fa-lock"></i>&nbsp;<?= $nboard > 1 ? 'Tableaux' : 'Tableau'; ?></span>
    </span>

</span>

<span class="divider float-left"></span>

<span class="p-user-joined-date">
     <span class="span-horizontal-group small-date-text">
        <span class="span-in-left"><i class='fa fa-clock-o'></i></span>
        <span class="span-in-right">Avec&nbsp;<?= WEBSITE_NAME ?>&nbsp;depuis
            <?= e($user->created_at); ?></span>
    </span>
</span>