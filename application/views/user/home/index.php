<?php

$currency_option = settingValue('currency_option');

$bgquery = $this->db->query("select upload_image from bgimage WHERE bgimg_for = 'banner' limit 1");
$bgresult = $bgquery->row_array();

if (!empty($bgresult['upload_image'])) {
    $bgimg = base_url() . $bgresult['upload_image'];
} else {
    $bgimg = base_url() . 'assets/img/banner.jpg';
}

$banner_showhide = $this->db->select('banner_settings, main_search, popular_search')->get_where('bgimage', array('bgimg_id' => 1))->row();

?>

<?php if ($banner_showhide->banner_settings == 1) { ?>
    <section class="hero-section">
        <div class="layer">
            <div class="home-banner" style="background-image: url('<?php echo $bgimg; ?>');"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-search">
                            <h1><?php echo (!empty($home_banner_language['title'])) ? ($home_banner_language['title']) : 'Worlds Largest Marketplace';  ?></h1>
                            <p><?php echo (!empty($home_banner_language['content'])) ? ($home_banner_language['content']) : 'Search From 0 Awesome Verified Ads!';  ?></p>

                            <?php if ($banner_showhide->main_search == 1) { ?>
                                <div class="search-box">
                                    <form action="<?php echo base_url(); ?>search" id="search_service" class="search-style" method="post">

                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                        <div class="search-input line">
                                            <i class="fas fa-tv bficon"></i>
                                            <div class="form-group mb-0">
                                                <input type="text" class="form-control common_search search" name="common_search" id="search-blk" placeholder="<?php echo (!empty($user_language[$user_selected]['lg_what_you_look'])) ? $user_language[$user_selected]['lg_what_you_look'] : $default_language['en']['lg_what_you_look']; ?>">
                                            </div>
                                        </div>
                                        <div class="search-input">
                                            <i class="fas fa-location-arrow bficon"></i>
                                            <div class="form-group mb-0">
                                                <input type="text" class="form-control" value="<?php echo $this->session->userdata('user_address'); ?>" name="user_address" id="user_address" placeholder="<?php echo (!empty($user_language[$user_selected]['lg_your_location'])) ? $user_language[$user_selected]['lg_your_location'] : $default_language['en']['lg_your_location']; ?>">
                                                <input type="hidden" value="" name="user_latitude" id="user_latitude">
                                                <input type="hidden" value="" name="user_longitude" id="user_longitude">
                                                <?php if (settingValue('location_type') == 'live') { ?>
                                                    <a class="current-loc-icon current_location" data-id="1" href="javascript:void(0);" onclick="change_location()"><i class="fas fa-crosshairs"></i></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="search-btn">
                                            <button class="btn search_service" name="search" value="search" type="button"><?php echo (!empty($user_language[$user_selected]['lg_search'])) ? $user_language[$user_selected]['lg_search'] : $default_language['en']['lg_search']; ?></button>
                                        </div>
                                    <?php } ?>
                                    </form>
                                </div>

                                <ul id="searchResult"></ul>
                                <?php if ($banner_showhide->popular_search == 1) { ?>
                                    <div class="search-cat">
                                        <i class="fas fa-circle"></i>
                                        <span><?php echo (!empty($user_language[$user_selected]['popular_title'])) ? ($user_language[$user_selected]['popular_title']) : ($default_language['en']['popular_title'] ?? "Popular Services");  ?></span>
                                        <?php
                                        foreach ($popular as $popular_services) { ?>
                                            <a href="<?php echo base_url() . 'service-preview/' . $popular_services['url']; ?>">
                                                <?php echo $popular_services['service_title'] ?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?php if (settingValue('featured_showhide') == 1) {
?>
    <section class="category-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="heading">
                                <h2><?php echo (!empty($home_featured_language['title'])) ? ($home_featured_language['title']) : ($default_language['en']['lg_Featured_Categories'] ?? "Featured Categories");  ?></h2>
                                <span><?php echo (!empty($home_featured_language['content'])) ? ($home_featured_language['content']) : ($default_language['en']['lg_Featured_Categories_content'] ?? 'Search From Featured Categories');  ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="viewall">
                                <h4><a href="<?php echo base_url(); ?>all-categories"><?php echo (!empty($user_language[$user_selected]['lg_View_All'])) ? $user_language[$user_selected]['lg_View_All'] : ($default_language['en']['lg_View_All'] ?? "VIEW ALL"); ?> <i class="fas fa-angle-right"></i></a></h4>
                                <span><?php echo (!empty($home_featured_language['title'])) ? $home_featured_language['title'] : ($default_language['en']['lg_Featured_Categories'] ?? "Featured Categories"); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="catsec">
                        <div class="row">
                            <?php
                            if (!empty($featured_category)) {

                                foreach ($featured_category as $crows) { ?>
                                    <div class="col-lg-4 col-md-6">
                                        <?php
                                        $RemoveSpecialChar = $this->home->RemoveSpecialChar($crows['category_name']);
                                        $output =  preg_replace('/[^A-Za-z0-9-]+/', '-', $RemoveSpecialChar);
                                        $cat_slug = str_replace(" ", "-", trim($output));
                                        $inputs['category_slug'] = strtolower($cat_slug);
                                        $cat_slug = ($crows['category_slug']) ? $crows['category_slug'] : $inputs['category_slug'];
                                        $data = array('category_slug' => $cat_slug);

                                        if (empty($crows['category_slug'])) {
                                            $this->db->update('categories', $data, array('id' => $crows['id']));
                                        }

                                        $cat_image = $placholder_img ? $placholder_img : base_url() . 'uploads/placeholder_img/1641376256_banner.jpg';
                                        if ($crows['category_image'] && file_exists($crows['category_image'])) {
                                            $cat_image = $crows['category_image'];
                                        }

                                        ?>
                                        <a href="<?php echo base_url(); ?>search/<?php echo str_replace(' ', '-', strtolower($crows['category_slug'])); ?>">
                                            <div class="cate-widget">
                                                <img alt="Category Image" src="<?php echo base_url() . $cat_image; ?>" class="lazyload" loading="lazy" alt="">
                                                <div class="cate-title">
                                                    <h3><span><i class="fas fa-circle"></i> <?php echo $crows['category_name']; ?></span></h3>
                                                </div>
                                                <div class="cate-count">
                                                    <i class="fas fa-clone"></i> <?php echo $crows['category_count']; ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php
                                }
                            } else { ?>

                                <div class="col-lg-12">
                                    <div class="category">
                                        <h5 class="text-center"><?php echo (!empty($user_language[$user_selected]['lg_no_categories_found'])) ? $user_language[$user_selected]['lg_no_categories_found'] : ($default_language['en']['lg_no_categories_found'] ?? "No Categories Found") ?></h5>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?php if (settingValue('newest_ser_showhide') == 1) { ?>
    <section class="popular-services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="heading">
                                <h2><?php echo (!empty($home_latest_language['title'])) ? ($home_latest_language['title']) : ($default_language['en']['lg_newest_services'] ?? 'Newest Services');  ?></h2>
                                <span><?php echo (!empty($home_latest_language['content'])) ? ($home_latest_language['content']) : ($default_language['en']['lg_newest_service_content'] ?? 'Newest Service Contents');  ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="viewall">
                                <h4><a href="<?php echo base_url(); ?>all-services"><?php echo (!empty($user_language[$user_selected]['lg_View_All'])) ? $user_language[$user_selected]['lg_View_All'] : ($default_language['en']['lg_View_All'] ?? "VIEW ALL"); ?> <i class="fas fa-angle-right"></i></a></h4>
                                <span><?php echo (!empty($home_latest_language['title'])) ? $home_latest_language['title'] : ($default_language['en']['lg_newested_services'] ?? 'Newested Services'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="service-carousel">
                        <div class="service-slider owl-carousel owl-theme">
                            <?php
                            if (!empty($newest)) {
                                foreach ($newest as $nrows) {
                                    $pro_status_check = $this->db->select('status')->from('providers')->where('id', (int) $nrows['user_id'])->get()->row_array();
                                    if ($pro_status_check['status'] == 1) {
                                        $this->db->select("service_image");
                                        $this->db->from('services_image');
                                        $this->db->where("service_id", $nrows['id']);
                                        $this->db->where("status", 1);
                                        $image = $this->db->get()->row_array();

                                        $lang = ($this->session->userdata('user_select_language')) ? $this->session->userdata('user_select_language') : settingValue('language');

                                        $cat_name = $this->db->select('cl.category_name')->from('categories c')->join('categories_lang cl', 'cl.category_id = c.id', 'left')->where(array('c.id' => $nrows['category'], 'c.status' => 1, 'cl.lang_type' => $lang))->get()->row()->category_name;

                                        $provider_details = $this->db->select('profile_img')->where('id', $nrows['user_id'])->get('providers')->row_array();

                                        $this->db->select('AVG(rating)');
                                        $this->db->where(array('service_id' => $nrows['id'], 'status' => 1));
                                        $this->db->from('rating_review');
                                        $rating = $this->db->get()->row_array();

                                        $avg_rating = round($rating['AVG(rating)'], 1);
                                        $user_currency_code = '';
                                        $userId = $this->session->userdata('id');
                                        if (!empty($userId)) {
                                            $service_amount = $nrows['service_amount'];
                                            $type = $this->session->userdata('usertype');
                                            if ($type == 'user') {
                                                $user_currency = get_user_currency();
                                            } else if ($type == 'provider') {
                                                $user_currency = get_provider_currency();
                                            }
                                            $user_currency_code = $user_currency['user_currency_code'];
                                            $service_amount = get_gigs_currency($nrows['service_amount'], $nrows['currency_code'], $user_currency_code);
                                        } else {
                                            $user_currency_code = settings('currency');
                                            $service_currency_code = $nrows['currency_code'];
                                            $service_amount = get_gigs_currency($nrows['service_amount'], $nrows['currency_code'], $user_currency_code);
                                        }

                                        if (is_nan($service_amount) || is_infinite($service_amount)) {
                                            $service_amount = $nrows['service_amount'];
                                        }

                                        $ser_img = base_url() . 'assets/img/service-placeholder.jpg';
                                        if (isset($image['service_image']) && file_exists($image['service_image'])) {
                                            $ser_img = base_url() . $image['service_image'];
                                        }

                                        $profile_img = base_url() . 'assets/img/user.jpg';

                                        if ($provider_details['profile_img'] != '' && isset($provider_details['profile_img']) && file_exists($provider_details['profile_img'])) {
                                            $profile_img = base_url() . $provider_details['profile_img'];
                                        }
                            ?>
                                        <div class="service-widget">
                                            <div class="service-img">
                                                <a href="<?php echo base_url() . 'service-preview/' . $nrows['url']; ?>">
                                                    <img class="img-fluid serv-img lazyload" alt="Service Image" loading="lazy" src="<?php echo $ser_img; ?>" alt="">
                                                </a>
                                                <div class="item-info">
                                                    <div class="service-user">
                                                        <img loading="lazy" class="lazyload" src="<?php echo $profile_img ?>">
                                                        <span class="service-price"><?php echo currency_conversion($user_currency_code) . $service_amount; ?></span>
                                                    </div>

                                                    <div class="cate-list">
                                                        <a class="bg-yellow" href="<?php echo base_url() . 'search/' . str_replace(' ', '-', strtolower($cat_name)); ?>"><?php echo ucfirst($cat_name); ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="service-content">
                                                <?php
                                                $RemoveSpecialChar = $this->home->RemoveSpecialChar($nrows['service_title']);

                                                $output =  preg_replace('/[^A-Za-z0-9-]+/', '-', $RemoveSpecialChar);
                                                $service_url = str_replace(" ", "-", trim($output));
                                                $inputs['url'] = strtolower($service_url);
                                                $service_url = ($nrows['url']) ? $nrows['url'] : $inputs['url'];
                                                $data = array('url' => $service_url);

                                                if (empty($nrows['url'])) {
                                                    $this->db->update('services', $data, array('id' => $nrows['id']));
                                                }
                                                ?>
                                                <h3 class="title">
                                                    <?php
                                                    $ser_lang = ($this->session->userdata('user_select_language')) ? $this->session->userdata('user_select_language') : 'en';
                                                    $this->db->select('service_name');
                                                    $this->db->where('service_id', $nrows['id']);
                                                    $this->db->where('lang_type', $ser_lang);
                                                    $service_name = $this->db->get('service_lang')->row_array();
                                                    ?>
                                                    <a href="<?php echo base_url() . 'service-preview/' . $service_url; ?>"><?php echo ucfirst($service_name['service_name'] ?? $nrows['service_title']); ?></a>
                                                </h3>

                                                <div class="rating">
                                                    <?php
                                                    for ($x = 1; $x <= $avg_rating; $x++) {
                                                        echo '<i class="fas fa-star filled"></i>';
                                                    }

                                                    if (strpos($avg_rating, '.')) {
                                                        echo '<i class="fas fa-star"></i>';
                                                        $x++;
                                                    }

                                                    while ($x <= 5) {
                                                        echo '<i class="fas fa-star"></i>';
                                                        $x++;
                                                    }
                                                    ?>
                                                    <span class="d-inline-block average-rating">(<?php echo $avg_rating ?>)</span>
                                                </div>
                                                <div class="user-info">
                                                    <div class="row">
                                                        <?php if ($this->session->userdata('id') != '') {
                                                        ?>
                                                            <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                                        <?php } else { ?>
                                                            <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                                        <?php } ?>
                                                        <span class="col ser-location"><span><?php echo ucfirst($nrows['service_location']); ?></span> <i class="fas fa-map-marker-alt ml-1"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                                    }
                                }
                            } else {
                                echo '<div> 
                                    <p class="mb-0">' . (!empty($user_language[$user_selected]["lg_no_service"])) ? $user_language[$user_selected]["lg_no_service"] : ($default_language["en"]["lg_no_service"] ?? "No Service Found");
                                '</p>
                                </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php  }  ?>

<?php if (settingValue('popular_ser_showhide') == 1) { ?>
    <section class="popular-services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="heading">
                                <?php //foreach ($home_popular_language as $popular_language) { 
                                ?>
                                <h2><?php echo (!empty($home_popular_language['title'])) ? ($home_popular_language['title']) : ($default_language['en']['lg_popular_services'] ?? 'Popular Services');  ?></h2>
                                <span><?php echo (!empty($home_popular_language['content'])) ? ($home_popular_language['content']) : ($default_language['en']['lg_popular_service_content'] ?? 'Popular Service Contents');  ?></span>
                                <?php //} 
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="viewall">
                                <h4><a href="<?php echo base_url(); ?>all-services"><?php echo (!empty($user_language[$user_selected]['lg_View_All'])) ? $user_language[$user_selected]['lg_View_All'] : ($default_language['en']['lg_View_All'] ?? "VIEW ALL"); ?> <i class="fas fa-angle-right"></i></a></h4>
                                <span><?php echo (!empty($user_language[$user_selected]['lg_Most_Popular'])) ? $user_language[$user_selected]['lg_Most_Popular'] : ($default_language['en']['lg_Most_Popular'] ?? "Most Popular"); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="service-carousel">
                        <div class="service-slider owl-carousel owl-theme">
                            <?php
                            if (!empty($services)) {
                                foreach ($services as $srows) {
                                    $pro_status_check = $this->db->select('status')->from('providers')->where('id', (int) $srows['user_id'])->get()->row_array();

                                    if ($pro_status_check['status'] == 1) {

                                        $this->db->select("service_image");
                                        $this->db->from('services_image');
                                        $this->db->where("service_id", $srows['id']);
                                        $this->db->where("status", 1);

                                        $image = $this->db->get()->row_array();

                                        $provider_details = $this->db->select('profile_img')->where('id', $srows['user_id'])->get('providers')->row_array();

                                        $this->db->select('AVG(rating)');
                                        $this->db->where(array('service_id' => $srows['id'], 'status' => 1));
                                        $this->db->from('rating_review');
                                        $rating = $this->db->get()->row_array();

                                        $avg_rating = round($rating['AVG(rating)'], 1);

                                        $user_currency_code = '';

                                        $userId = $this->session->userdata('id');

                                        if (!empty($userId)) {
                                            $service_amount = $srows['service_amount'];
                                            $type = $this->session->userdata('usertype');

                                            if ($type == 'user') {
                                                $user_currency = get_user_currency();
                                            } else if ($type == 'provider') {
                                                $user_currency = get_provider_currency();
                                            }
                                            $user_currency_code = $user_currency['user_currency_code'];
                                            $service_amount = get_gigs_currency($srows['service_amount'], $srows['currency_code'], $user_currency_code);
                                        } else {
                                            $user_currency_code = settings('currency');
                                            $service_currency_code = $srows['currency_code'];
                                            $service_amount = get_gigs_currency($srows['service_amount'], $srows['currency_code'], $user_currency_code);
                                        }
                                        if (is_nan($service_amount) || is_infinite($service_amount)) {
                                            $service_amount = $srows['service_amount'];
                                        }
                                        $RemoveSpecialChar = $this->home->RemoveSpecialChar($srows['service_title']);

                                        $output = preg_replace('!\s+!', ' ', $RemoveSpecialChar);
                                        $service_url = str_replace(" ", "-", trim($output));
                                        $inputs['url'] = strtolower($service_url);
                                        $service_url = ($srows['url']) ? $srows['url'] : $inputs['url'];

                                        $data = array('url' => $service_url);

                                        if (empty($srows['url'])) {
                                            $this->db->update('services', $data, array('id' => $srows['id']));
                                        }

                                        $ser_img = base_url() . 'assets/img/service-placeholder.jpg';
                                        if (isset($image['service_image']) && file_exists($image['service_image'])) {
                                            $ser_img = base_url() . $image['service_image'];
                                        }

                                        $profile_img = base_url() . 'assets/img/user.jpg';
                                        if (isset($provider_details['profile_img']) && file_exists($provider_details['profile_img'])) {
                                            $profile_img = base_url() . $provider_details['profile_img'];
                                        }

                            ?>

                                        <div class="service-widget">
                                            <div class="service-img">

                                                <a href="<?php echo base_url() . 'service-preview/' . $srows['url']; ?>">
                                                    <img class="img-fluid serv-img lazyload" loading="lazy" alt="Service Image" src="<?php echo $ser_img; ?>" alt="">
                                                </a>
                                                <div class="item-info">
                                                    <div class="service-user">
                                                        <img loading="lazy" class="lazyload" src="<?php echo $profile_img; ?>">
                                                        <span class="service-price"><?php echo currency_conversion($user_currency_code) . $service_amount; ?></span>
                                                    </div>

                                                    <div class="cate-list">
                                                        <?php
                                                        $this->db->select('id');
                                                        $this->db->where('category_name', $srows['category_name']);
                                                        $cat_names = $this->db->get('categories')->row();
                                                        $cat_langs = ($this->session->userdata('user_select_language')) ? $this->session->userdata('user_select_language') : 'en';
                                                        $this->db->select('category_name');
                                                        $this->db->where('category_id', $cat_names->id);
                                                        $this->db->where('lang_type', $cat_langs);
                                                        $cat_namess = $this->db->get('categories_lang')->row();
                                                        ?>
                                                        <a class="bg-yellow" href="<?php echo base_url() . 'search/' . str_replace(' ', '-', strtolower($srows['category_name'])); ?>"><?php echo $cat_namess->category_name; ?></a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="service-content">
                                                <h3 class="title">
                                                    <?php
                                                    $ser_lang = ($this->session->userdata('user_select_language')) ? $this->session->userdata('user_select_language') : 'en';
                                                    $this->db->select('service_name');
                                                    $this->db->where('service_id', $srows['id']);
                                                    $this->db->where('lang_type', $ser_lang);
                                                    $service_name = $this->db->get('service_lang')->row_array();
                                                    ?>
                                                    <a href="<?php echo base_url() . 'service-preview/' . $srows['url']; ?>"><?php echo ucfirst($service_name['service_name'] ?? $srows['service_title']); ?></a>
                                                </h3>

                                                <div class="rating">
                                                    <?php
                                                    for ($x = 1; $x <= $avg_rating; $x++) {
                                                        echo '<i class="fas fa-star filled"></i>';
                                                    }
                                                    if (strpos($avg_rating, '.')) {
                                                        echo '<i class="fas fa-star"></i>';
                                                        $x++;
                                                    }
                                                    while ($x <= 5) {
                                                        echo '<i class="fas fa-star"></i>';
                                                        $x++;
                                                    }
                                                    ?>
                                                    <span class="d-inline-block average-rating">(<?php echo $avg_rating ?>)</span>
                                                </div>
                                                <div class="user-info">
                                                    <div class="row">
                                                        <?php if ($this->session->userdata('id') != '') {
                                                        ?>
                                                            <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                                        <?php } else { ?>
                                                            <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                                        <?php } ?>

                                                        <span class="col ser-location"><span><?php echo ucfirst($srows['service_location']); ?></span> <i class="fas fa-map-marker-alt ml-1"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                                    }
                                }
                            } else {
                                echo '<div>	
									<p class="mb-0">' . (!empty($user_language[$user_selected]["lg_no_service"])) ? $user_language[$user_selected]["lg_no_service"] : ($default_language["en"]["lg_no_service"] ?? "No Service Found");
                                '</p>
								</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php  }  ?>
<?php if (settingValue('top_rating_showhide') == 1) { ?>
    <section class="popular-services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="heading">
                                <h2><?php echo (!empty($home_featured_ser_language['title'])) ? ($home_featured_ser_language['title']) : ($default_language["en"]["lg_featured_services"] ?? 'Featured Services');  ?></h2>
                                <span><?php echo (!empty($home_featured_ser_language['content'])) ? ($home_featured_ser_language['content']) : ($default_language["en"]["lg_featured_service_content"] ?? 'Featured Service Contents');  ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="viewall">
                                <h4><a href="<?php echo base_url(); ?>featured-services"><?php echo (!empty($user_language[$user_selected]['lg_View_All'])) ? $user_language[$user_selected]['lg_View_All'] : ($default_language['en']['lg_View_All'] ?? "VIEW ALL"); ?> <i class="fas fa-angle-right"></i></a></h4>
                                <span><?php echo (!empty($home_featured_ser_language['title'])) ? $home_featured_ser_language['title'] : ($default_language["en"]["lg_featured_services"] ?? 'Featured Services'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="service-carousel">
                        <div class="service-slider owl-carousel owl-theme">
                            <?php
                            if (!empty($top_rating_services)) {
                                foreach ($top_rating_services as $srows) {
                                    $pro_status_check = $this->db->select('status')->from('providers')->where('id', (int) $srows['user_id'])->get()->row_array();
                                    if ($pro_status_check['status'] == 1) {
                                        $lang = ($this->session->userdata('user_select_language')) ? $this->session->userdata('user_select_language') : settingValue('language');

                                        $feature_cat_name = $this->db->select('cl.category_name')->from('categories c')->join('categories_lang cl', 'cl.category_id = c.id', 'left')->where(array('c.id' => $srows['category'], 'c.status' => 1, 'cl.lang_type' => $lang))->get()->row()->category_name;
                                        $this->db->select("service_image");
                                        $this->db->from('services_image');
                                        $this->db->where("service_id", $srows['id']);
                                        $this->db->where("status", 1);
                                        $image = $this->db->get()->row_array();

                                        $provider_details = $this->db->where('id', $srows['user_id'])->get('providers')->row_array();

                                        $this->db->select('AVG(rating)');
                                        $this->db->where(array('service_id' => $srows['id'], 'status' => 1));
                                        $this->db->from('rating_review');
                                        $rating = $this->db->get()->row_array();

                                        $avg_rating = round($rating['AVG(rating)'], 1);

                                        $user_currency_code = '';

                                        $userId = $this->session->userdata('id');

                                        if (!empty($userId)) {
                                            $service_amount = $srows['service_amount'];
                                            $type = $this->session->userdata('usertype');

                                            if ($type == 'user') {
                                                $user_currency = get_user_currency();
                                            } else if ($type == 'provider') {
                                                $user_currency = get_provider_currency();
                                            }
                                            $user_currency_code = $user_currency['user_currency_code'];

                                            $service_amount = get_gigs_currency($srows['service_amount'], $srows['currency_code'], $user_currency_code);
                                        } else {
                                            $user_currency_code = settings('currency');
                                            $service_currency_code = $srows['currency_code'];
                                            $service_amount = get_gigs_currency($srows['service_amount'], $srows['currency_code'], $user_currency_code);
                                        }

                                        if (is_nan($service_amount) || is_infinite($service_amount)) {
                                            $service_amount = $srows['service_amount'];
                                        }
                                        $RemoveSpecialChar = $this->home->RemoveSpecialChar($srows['service_title']);

                                        $output = preg_replace('!\s+!', ' ', $RemoveSpecialChar);

                                        $service_url = str_replace(" ", "-", trim($output));

                                        $inputs['url'] = strtolower($service_url);

                                        $service_url = ($srows['url']) ? $srows['url'] : $inputs['url'];

                                        $data = array('url' => $service_url);

                                        if (empty($srows['url'])) {
                                            $this->db->update('services', $data, array('id' => $srows['id']));
                                        }

                                        $ser_img = base_url() . 'assets/img/service-placeholder.jpg';
                                        if (isset($image['service_image']) && file_exists($image['service_image'])) {
                                            $ser_img = base_url() . $image['service_image'];
                                        }

                                        $profile_img = base_url() . 'assets/img/user.jpg';
                                        if (isset($provider_details['profile_img']) && file_exists($provider_details['profile_img'])) {
                                            $profile_img = base_url() . $provider_details['profile_img'];
                                        }
                            ?>

                                        <div class="service-widget">
                                            <div class="service-img">
                                                <a href="<?php echo base_url() . 'service-preview/' . $srows['url']; ?>">
                                                    <img class="img-fluid serv-img lazyload" loading="lazy" alt="Service Image" src="<?php echo $ser_img; ?>" alt="">
                                                </a>

                                                <div class="item-info">
                                                    <div class="service-user">
                                                        <img loading="lazy" class="lazyload" src="<?php echo $profile_img; ?>">
                                                        <span class="service-price"><?php echo currency_conversion($user_currency_code) . $service_amount; ?></span>
                                                    </div>
                                                    <div class="cate-list">
                                                        <a class="bg-yellow" href="<?php echo base_url() . 'search/' . str_replace(' ', '-', strtolower($feature_cat_name)); ?>"><?php echo ucfirst($feature_cat_name); ?></a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="service-content">
                                                <h3 class="title">
                                                    <?php
                                                    $ser_lang = ($this->session->userdata('user_select_language')) ? $this->session->userdata('user_select_language') : 'en';
                                                    $this->db->select('service_name');
                                                    $this->db->where('service_id', $srows['id']);
                                                    $this->db->where('lang_type', $ser_lang);
                                                    $service_name = $this->db->get('service_lang')->row_array();
                                                    ?>
                                                    <a href="<?php echo base_url() . 'service-preview/' . $srows['url']; ?>"><?php echo ucfirst($service_name['service_name'] ?? $srows['service_title']); ?></a>

                                                </h3>
                                                <div class="rating">
                                                    <?php
                                                    for ($x = 1; $x <= $avg_rating; $x++) {
                                                        echo '<i class="fas fa-star filled"></i>';
                                                    }

                                                    if (strpos($avg_rating, '.')) {
                                                        echo '<i class="fas fa-star"></i>';
                                                        $x++;
                                                    }

                                                    while ($x <= 5) {
                                                        echo '<i class="fas fa-star"></i>';
                                                        $x++;
                                                    }
                                                    ?>

                                                    <span class="d-inline-block average-rating">(<?php echo $avg_rating ?>)</span>
                                                </div>
                                                <div class="user-info">
                                                    <div class="row">
                                                        <?php if ($this->session->userdata('id') != '') { ?>
                                                            <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                                        <?php } else { ?>
                                                            <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                                        <?php } ?>
                                                        <span class="col ser-location"><span><?php echo ucfirst($srows['service_location']); ?></span> <i class="fas fa-map-marker-alt ml-1"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                                    }
                                }
                            } else {
                                echo '<div> 
                                    <p class="mb-0">' . (!empty($user_language[$user_selected]["lg_no_service"])) ? $user_language[$user_selected]["lg_no_service"] : ($default_language["en"]["lg_no_service"] ?? "No Service Found");
                                '</p>
                                </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php  }  ?>

<!-- Blog Section -->

<?php if (settingValue('blog_showhide') == 1) { ?>
    <!-- Blog -->
    <section class="popular-services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="heading aos" data-aos="fade-up">
                                <h2><?php echo (!empty($home_blog_language['title'])) ? ($home_blog_language['title']) : ($default_language["en"]["lg_blogs"] ?? 'Blogs');  ?></h2>
                                <span><?php echo (!empty($home_blog_language['content'])) ? ($home_blog_language['content']) : ($default_language["en"]["lg_our_blog"] ?? 'Latest From Our Blog');  ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="viewall aos" data-aos="fade-up">
                                <h4><a href="<?php echo $base_url; ?>all-blogs"><?php echo (!empty($user_language[$user_selected]['lg_View_All'])) ? $user_language[$user_selected]['lg_View_All'] : ($default_language['en']['lg_View_All'] ?? "VIEW ALL"); ?> <i class="fas fa-angle-right"></i></a></h4>
                                <span><?php echo (!empty($home_blog_language['title'])) ? ($home_blog_language['title']) : ($default_language["en"]["lg_blogs"] ?? 'Blogs');  ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row aos" data-aos="fade-up">

                        <?php if ($blogs) {
                            foreach ($blogs as $post) { ?>
                                <!-- Blog Post -->
                                <div class="col-md-6 col-xl-4 col-sm-12 d-flex">
                                    <div class="blog grid-blog flex-fill">
                                        <div class="blog-image blog-inner-image">
                                            <?php if ($post['image_default'] != '' && (@getimagesize(base_url() . $post['image_default']))) { ?>
                                                <a href="<?php echo $base_url; ?>user-blog-details/<?php echo $post['url']; ?>">
                                                    <img class="img-fluid lazyload" loading="lazy" src="<?php echo $post['image_default']; ?>" alt="Post Image">
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?php echo $base_url; ?>user-blog-details/<?php echo $post['url']; ?>">
                                                    <img loading="lazy" class="lazyload" src="<?php echo base_url(); ?>assets/img/service-placeholder.jpg">
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="blog-content">
                                            <h3 class="blog-title"><a href="<?php echo $base_url; ?>user-blog-details/<?php echo $post['url']; ?>"><?php echo $post['title']; ?></a></h3>
                                            <div class="blog-read d-flex justify-content-between align-items-center">
                                                <div class="blog-date">
                                                    <p><i class="far fa-calendar mr-2"></i><?php echo  date(settingValue('date_format'), strtotime($post['createdAt'])); ?></p>
                                                </div>
                                                <div class="blog-read-more">
                                                    <a href="<?php echo $base_url; ?>user-blog-details/<?php echo $post['url']; ?>"> Read more<i class="fas fa-arrow-right ml-2"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Blog Post -->
                        <?php }
                        } else {
                            echo '<div> 
                                    <p class="mb-0">' . (!empty($user_language[$user_selected]["lg_no_blogs"])) ? $user_language[$user_selected]["lg_no_blogs"] : ($default_language["en"]["lg_no_blogs"] ?? "Blogs Not Found");
                            '</p>
                                </div>';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Blog -->
<?php } ?>

<?php if (settingValue('how_showhide') == 1) { ?>

    <section class="how-work">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading howitworks">
                        <h2><?php echo (!empty($home_how_it_language['title'])) ? ($home_how_it_language['title']) : ($default_language["en"]["lg_how_it_work"] ?? 'How It Works');  ?></h2>
                        <span><?php echo (!empty($home_how_it_language['content'])) ? ($home_how_it_language['content']) : ($default_language["en"]["lg_how_it_work_content"] ?? 'How It Works Content');  ?></span>
                    </div>
                    <div class="howworksec">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="howwork">
                                    <div class="iconround">
                                        <div class="steps">01</div>
                                        <?php

                                        if (!empty(settingValue('how_title_img_1'))) {
                                            echo '<img class="lazyload" loading="lazy" src="' . base_url() . settingValue('how_title_img_1') . '">';
                                        } else {
                                            echo '<img class="lazyload" loading="lazy" src="' . base_url() . 'assets/img/icon-1.png">';
                                        }
                                        ?>
                                    </div>
                                    <?php foreach ($home_step_1_language as $step_1_language) { ?>
                                        <h3><?php echo (!empty($step_1_language['title'])) ? ($step_1_language['title']) : 'Choose What To Do';  ?></h3>
                                        <p><?php echo (!empty($step_1_language['content'])) ? ($step_1_language['content']) : 'Aliquam lorem ante, dapibus in, viverra quis, feugiat Phasellus viverra nulla ut metus varius laoreet.';  ?></p>

                                        <?php /*  ?> <h3><?php echo (!empty($user_language[$user_selected]['step_1_title'])) ? ($user_language[$user_selected]['step_1_title']) : 'Choose What To Do';  ?></h3>
                                         <p><?php echo (!empty($user_language[$user_selected]['step_1_content'])) ? ($user_language[$user_selected]['step_1_content']) : 'Aliquam lorem ante, dapibus in, viverra quis, feugiat Phasellus viverra nulla ut metus varius laoreet.';  ?></p> <?php  */ ?>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="howwork">
                                    <div class="iconround">
                                        <div class="steps">02</div>
                                        <?php

                                        if (!empty(settingValue('how_title_img_2'))) {
                                            echo '<img class="lazyload" loading="lazy" src="' . base_url() . settingValue('how_title_img_2') . '">';
                                        } else {
                                            echo '<img class="lazyload" loading="lazy" src="' . base_url() . 'assets/img/icon-2.png">';
                                        }
                                        ?>
                                    </div>
                                    <?php foreach ($home_step_2_language as $step_2_language) {  ?>
                                        <h3><?php echo (!empty($step_2_language['title'])) ? ($step_2_language['title']) : 'Find What You Want';  ?></h3>

                                        <p><?php echo (!empty($step_2_language['content'])) ? ($step_2_language['content']) : 'Aliquam lorem ante, dapibus in, viverra quis, feugiat Phasellus viverra nulla ut metus varius laoreet.';  ?></p>

                                        <?php  /* ?><h3><?php echo (!empty($user_language[$user_selected]['step_2_title'])) ? ($user_language[$user_selected]['step_2_title']) : 'Find What You Want';  ?></h3>

                                        <p><?php echo (!empty($user_language[$user_selected]['step_2_content'])) ? ($user_language[$user_selected]['step_2_content']) : 'Aliquam lorem ante, dapibus in, viverra quis, feugiat Phasellus viverra nulla ut metus varius laoreet.';  ?></p><?php  */  ?>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="howwork">
                                    <div class="iconround">
                                        <div class="steps">03</div>
                                        <?php
                                        if (!empty(settingValue('how_title_img_3'))) {
                                            echo '<img class="lazyload" loading="lazy" src="' . base_url() . settingValue('how_title_img_3') . '">';
                                        } else {
                                            echo '<img class="lazyload" loading="lazy" src="' . base_url() . 'assets/img/icon-3.png">';
                                        }
                                        ?>
                                    </div>

                                    <?php foreach ($home_step_3_language as $step_3_language) {  ?>
                                        <h3><?php echo (!empty($step_3_language['title'])) ? ($step_3_language['title']) : 'Amazing Places';  ?></h3>

                                        <p><?php echo (!empty($step_3_language['content'])) ? ($step_3_language['content']) : 'Aliquam lorem ante, dapibus in, viverra quis, feugiat Phasellus viverra nulla ut metus varius laoreet.';  ?></p>
                                        
                                        <?php /* ?><h3><?php echo (!empty($user_language[$user_selected]['step_3_title'])) ? ($user_language[$user_selected]['step_3_title']) : 'Amazing Places';  ?></h3>

                                        <p><?php echo (!empty($user_language[$user_selected]['step_3_content'])) ? ($user_language[$user_selected]['step_3_content']) : 'Aliquam lorem ante, dapibus in, viverra quis, feugiat Phasellus viverra nulla ut metus varius laoreet.';  ?></p> <?php  */  ?>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?php if (settingValue('download_showhide') == 1) { ?>
    <section class="app-section d-none" id="how-work">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading howitworks">
                        <h2><?php echo (!empty($home_down_language['title'])) ? ($home_down_language['title']) : 'Download Our App';  ?></h2>
                        <span><?php echo (!empty($home_down_language['content'])) ? ($home_down_language['content']) : 'Aliquam lorem ante, dapibus in, viverra quis';  ?></span>

                        <div class="mt-3">
                            <a href="<?= (settingValue('app_store_link') ? settingValue('app_store_link') : '#') ?>" target="_blank" rel="noopener noreferrer"><img class="thumbnail m-b-0 lazyload" loading="lazy" src="<?php echo base_url() . settingValue('app_store_img'); ?>"></a>
                            <a href="<?= (settingValue('play_store_link') ? settingValue('play_store_link') : '#') ?>" target="_blank" rel="noopener noreferrer"><img class="thumbnail m-b-0 lazyload" loading="lazy" src="<?php echo base_url() . settingValue('play_store_img'); ?>"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<!-- App Section -->