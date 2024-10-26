
<div class="page-wrapper">
			<div class="content container-fluid">			
                <div class="row justify-content-center">			
                    <div class="col-lg-10 col-xl-9">			
                
                        <!-- Blog Details-->
                        <div class="blog-view">
                            <div class="blog-single-post">
                                <a href="<?php echo $base_url; ?>blogs" class="back-btn"><i class="feather-chevron-left"></i> Back</a>
                                <div class="blog-image">
                                    <a href="javascript:void(0);"><img alt="" src="assets/img/category/blog-detail.png" class="img-fluid"></a>
                                </div>
                                <h3 class="blog-title"><?php echo $posts[0]['title']; ?></h3>
                                <div class="blog-info">
                                    <div class="post-list">
                                        <ul>
                                            <li>
                                                <?php $profileImage = (file_exists($posts[0]['profile_img']))?$posts[0]['profile_img']:'assets/img/user.jpg'; ?>
                                                <div class="post-author">
                                                    <a href="<?php echo $base_url; ?>admin-profile"><img src="<?php echo  $base_url."/".$profileImage; ?>" alt="<?php echo $posts[0]['full_name']; ?>"> <span>by <?php echo $posts[0]['full_name']; ?> </span></a>
                                                </div>
                                            </li>
                                            <li><i class="feather-clock"></i><?php echo  date(settingValue('date_format'), strtotime($posts[0]['createdAt'])); ?></li>
                                            <li><i class="feather-grid"></i> <?php echo $posts[0]['cat_name']; ?></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="blog-content">
                                <?php echo $posts[0]['content']; ?>
                                </div>
                            </div>
                            
                            <!-- About Author -->
                            <div class="card author-widget clearfix">
                                <div class="card-header">
                                    <h4 class="card-title">About Author</h4>
                                </div>
                                <div class="card-body">
                                    <div class="about-author">
                                        <div class="about-author-img">
                                            <div class="author-img-wrap">
                                                 <?php $profileImage = (file_exists($posts[0]['profile_img']))?$posts[0]['profile_img']:'assets/img/user.jpg'; ?>
                                                <a href="<?php echo $base_url; ?>admin-profile"><img class="img-fluid" alt="" src="<?php echo  $base_url."/".$profileImage; ?>"></a>
                                            </div>
                                        </div>
                                        <div class="author-details">
                                            <a href="<?php echo $base_url; ?>admin-profile" class="blog-author-name"><?php echo $posts[0]['full_name']; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /About Author -->
                    
                        </div>
                    </div>
                </div>
                <!-- /Blog Details-->
        
            </div>
		</div> 