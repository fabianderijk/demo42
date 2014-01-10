  <header>
      <?php if ($logo): ?>
        <div class="logo">
          <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
            <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
          </a>
        </div>
      <?php endif; ?>

      <?php if ($main_menu): ?>
        <nav>
          <?php print theme('links__system_main_menu', array('links' => $main_menu)); ?>
        </nav>
      <?php endif; ?>

      <?php print render($page['header']); ?>
  </header>

  <div class="wrapper">
    <?php if ($breadcrumb): ?>
      <div id="breadcrumb"><?php print $breadcrumb; ?></div>
    <?php endif; ?>

    <?php print $messages; ?>

    <section class="content column">
      <?php if ($page['highlighted']): ?><div id="highlighted"><?php print render($page['highlighted']); ?></div><?php endif; ?>
      <a id="main-content"></a>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?><h1 class="title" id="page-title"><?php print $title; ?></h1><?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
      <?php print render($page['content']); ?>
      <?php print $feed_icons; ?>
    </section>

    <aside class="column sidebar first <?php if (!isset($page['sidebar_first']) || empty($page['sidebar_first'])) : print 'sidebar-empty'; endif; ?> ">
      <?php if ($page['sidebar_first']) : ?>
        <?php print render($page['sidebar_first']); ?>
      <?php endif; ?>
    </aside> <!-- /.section, /#sidebar-first -->

    <aside class="column sidebar second <?php if (!isset($page['sidebar_second']) || empty($page['sidebar_second'])) : print 'sidebar-empty'; endif; ?>">
      <?php if ($page['sidebar_second']): ?>
        <?php print render($page['sidebar_second']); ?>
      <?php endif; ?> 
    </aside> <!-- /.section, /#sidebar-second -->

  </div>
  
  <footer>
    <?php print render($page['footer']); ?>
  </footer>