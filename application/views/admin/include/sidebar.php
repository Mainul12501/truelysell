<?php
$page = $this->uri->segment(1);
$active = $this->uri->segment(2);
$page2 = $this->uri->segment(3);
$access_result_data_array = $this->session->userdata('access_module');
$admin_id = $this->session->userdata('admin_id');
$sidebar = $language_content;
?>
<div class="sidebar" id="sidebar">
	<div class="sidebar-logo">
		<a href="<?php echo $base_url; ?>dashboard">
			<img src="<?php echo $base_url . settingValue('header_icon'); ?>" alt="" class="img-fluid">
		</a>
	</div>
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
				<li class="menu-title">
					<span>
						<?php echo (!empty($sidebar['lg_admin_main'])) ? ($sidebar['lg_admin_main']) : 'Main';  ?>
					</span>
				</li>
				<li class="<?php echo ($page == 'dashboard') ? 'active' : ''; ?>">
					<a href="<?php echo $base_url; ?>dashboard"><i class="fas fa-columns"></i>
						<span>
							<?php echo (!empty($sidebar['lg_admin_dashboard'])) ? ($sidebar['lg_admin_dashboard']) : 'Dashboard';  ?>
						</span>
					</a>
				</li>

				<?php if (in_array(4, $access_result_data_array) || in_array(3, $access_result_data_array) || in_array(73, $access_result_data_array) || in_array(69, $access_result_data_array) || in_array(70, $access_result_data_array) || in_array(71, $access_result_data_array)) { ?>
					<li class="menu-title">
						<span>
							<?php echo (!empty($sidebar['lg_admin_services'])) ? ($sidebar['lg_admin_services']) : 'Services';  ?>
						</span>
					</li>
					<li class="submenu <?php echo ($page == 'service-list' || $page == 'service-details' || $active == 'add-service' || $page == 'payment-list' || $page == 'pending-service-details' || $active == 'pending-service-list') ? 'active' : ''; ?>">
						<a href="#">
							<i class="fas fa-bullhorn"></i> <span> <?php echo (!empty($sidebar['lg_admin_services'])) ? ($sidebar['lg_admin_services']) : 'Services';  ?></span><span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
						</a>
						<ul>
							<?php if (in_array(3, $access_result_data_array)) { ?>
								<li>
									<a href="<?php echo $base_url; ?>admin/add-service" class="<?php echo ($active == 'add-service') ? 'active' : ''; ?>"> <span><?php echo (!empty($sidebar['lg_add_services'])) ? ($sidebar['lg_add_services']) : 'Add Services';  ?></span></a>
								</li>
							<?php }
							if (in_array(68, $access_result_data_array)) { ?>
								<li>
									<a href="<?php echo $base_url; ?>service-list" class="<?php echo ($page == 'service-list') ? 'active' : ''; ?>"> <span><?php echo (!empty($sidebar['lg_admin_all_services'])) ? ($sidebar['lg_admin_all_services']) : 'All Services';  ?></span></a>
								</li>
							<?php }
							if (in_array(69, $access_result_data_array)) { ?>
								<li>
									<a href="<?php echo $base_url; ?>admin/pending-service-list" class="<?php echo ($active == 'pending-service-list' || $page == 'pending-service-details') ? 'active' : ''; ?>"><span><?php echo (!empty($sidebar['lg_admin_pending_service'])) ? ($sidebar['lg_admin_pending_service']) : 'Pending Services';  ?></span></a>
								</li>
							<?php }
							if (in_array(70, $access_result_data_array)) { ?>
								<li>
									<a href="<?php echo $base_url; ?>deleted-service-list" class="<?php echo ($page == 'deleted-service-list') ? 'active' : '';
																									echo ($page == 'deleted-service-details') ? 'active' : ''; ?>"><span><?php echo (!empty($sidebar['lg_admin_deleted_services'])) ? ($sidebar['lg_admin_deleted_services']) : 'Deleted Services';  ?></span></a>
								</li>
							<?php }
							if (in_array(71, $access_result_data_array)) { ?>
								<li>
									<a href="<?php echo $base_url; ?>inactive-service-list" class="<?php echo ($page == 'inactive-service-list') ? 'active' : '';
																									echo ($page == 'inactive-service-details') ? 'active' : ''; ?>"><span><?php echo (!empty($sidebar['lg_admin_inactive_services'])) ? ($sidebar['lg_admin_inactive_services']) : 'Inactive Services';  ?></span></a>
								</li>
							<?php }
							if (in_array(6, $access_result_data_array)) { ?>
								<li>
									<a href="<?php echo $base_url; ?>payment-list" class="<?php echo ($page == 'payment-list') ? 'active' : '';
																							echo ($page == 'admin-payment') ? 'active' : ''; ?>"><span><?php echo (!empty($sidebar['lg_admin_payments'])) ? ($sidebar['lg_admin_payments']) : 'Payments';  ?></span></a>
								</li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
				<?php if (in_array(2, $access_result_data_array) || in_array(3, $access_result_data_array)) { ?>
					<li class="submenu <?php echo ($page == 'categories' || $page == 'add-category' || $page == 'edit-category' || $page == 'subcategories' || $page == 'add-subcategory' || $page == 'edit-subcategory' || $page2 == 'categories') ? 'active' : ''; ?>">
						<a href="#">
							<i class="fas fa-layer-group"></i> <span><?php echo (!empty($sidebar['lg_admin_categories'])) ? ($sidebar['lg_admin_categories']) : 'Categories';  ?></span> <span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
						</a>
						<ul>
							<?php
							if (in_array(2, $access_result_data_array)) {
							?>
								<li>
									<a class="<?php echo ($page == 'categories' || $page == 'add-category' || $page == 'edit-category' || $page2 == 'categories') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>categories"> <span><?php echo (!empty($sidebar['lg_admin_categories'])) ? ($sidebar['lg_admin_categories']) : 'Categories';  ?></span></a>
								</li>
							<?php
							}
							if (in_array(3, $access_result_data_array)) {
							?>
								<li>
									<a class="<?php echo ($page == 'subcategories' || $page == 'add-subcategory' || $page == 'edit-subcategory') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>subcategories"> <span><?php echo (!empty($sidebar['lg_admin_sub_categories'])) ? ($sidebar['lg_admin_sub_categories']) : 'Sub Categories';  ?></span></a>
								</li>
							<?php
							}
							?>
						</ul>
					</li>
				<?php } ?>
				<?php if (in_array(7, $access_result_data_array) || in_array(8, $access_result_data_array)) { ?>
					<li class="submenu <?php echo ($active == 'reviews-type' || $page == 'add-reviews-type' || $page == 'edit-reviews-type' || $page == 'review-reports' || $page == 'add-review-reports' || $page == 'edit-review-reports' || $page == 'view-review') ? 'active' : ''; ?>">
						<a href="#">
							<i class="fas fa-star-half-alt"></i> <span><?php echo (!empty($sidebar['lg_admin_ratings'])) ? ($sidebar['lg_admin_ratings']) : 'Reviews';  ?> </span> <span class="menu-arrow"><i class="fas fa-angle-right"></i></span></a>
						<ul>

							<?php if (in_array(7, $access_result_data_array)) { ?>
								<li>
									<a href="<?php echo $base_url; ?>reviews-type" class="<?php echo ($page == 'reviews-type') ? 'active' : '';
																							echo ($page == 'add-reviews-type') ? 'active' : '';
																							echo ($page == 'edit-reviews-type') ? 'active' : ''; ?>"><span><?php echo (!empty($sidebar['lg_admin_rating_type'])) ? ($sidebar['lg_admin_rating_type']) : 'Reviews Type';  ?></span></a>
								</li>
							<?php }
							if (in_array(8, $access_result_data_array)) { ?>
								<li>
									<a href="<?php echo $base_url; ?>review-reports" class="<?php echo ($page == 'review-reports') ? 'active' : '';
																							echo ($page == 'add-review-reports') ? 'active' : '';
																							echo ($page == 'edit-review-reports') ? 'active' : ''; ?>"><span><?php echo (!empty($sidebar['lg_admin_ratings'])) ? ($sidebar['lg_admin_ratings']) : 'Reviews';  ?></span></a>
								</li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
				<?php if (in_array(5, $access_result_data_array)) { ?>
					<li class="menu-title">
						<span>
							<?php echo (!empty($sidebar['lg_admin_Bookings'])) ? ($sidebar['lg_admin_Bookings']) : 'Booking';  ?>
						</span>
					</li>
					<li class="<?php echo ($active == 'total-report' || $active == 'pending-report' || $active == 'inprogress-report' || $active == 'complete-report' || $active == 'reject-report' || $active == 'cancel-report' || $page == 'reject-payment') ? 'active' : ''; ?>">
						<a href="<?php echo $base_url; ?>admin/total-report"><i class="far fa-calendar-check"></i> <span> <?php echo (!empty($sidebar['lg_admin_booking_list'])) ? ($sidebar['lg_admin_booking_list']) : 'Booking List';  ?></span></a>
					</li>
				<?php } ?>
				<?php if (in_array(45, $access_result_data_array) || in_array(46, $access_result_data_array) || in_array(10, $access_result_data_array)) { ?>
					<li class="submenu <?php echo ($active == 'add-payouts' || $active == 'payout-requests' || $active == 'completed-payouts') ? 'active' : ''; ?>">
						<a href="#"><i class="fas fa-hashtag"></i>
							<span>
								<?php echo (!empty($sidebar['lg_admin_Payout'])) ? ($sidebar['lg_admin_Payout']) : 'Payout';  ?>
							</span>
							<span class="menu-arrow"><i class="fas fa-angle-right"></i></span></a>
						<ul>
							<?php if (in_array(45, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'add-payouts') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/add-payouts">
										<span>
											<?php echo (!empty($sidebar['lg_admin_add_payout'])) ? ($sidebar['lg_admin_add_payout']) : 'Add Payout';  ?>
										</span>
									</a>
								</li>
							<?php }
							if (in_array(46, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'payout-requests') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/payout-requests">
										<span>
											<?php echo (!empty($sidebar['lg_admin_payout_request'])) ? ($sidebar['lg_admin_payout_request']) : 'Payout Requests';  ?>
										</span>
									</a>
								</li>
							<?php }
							if (in_array(47, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'completed-payouts') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/completed-payouts">
										<span>
											<?php echo (!empty($sidebar['lg_admin_payout_list'])) ? ($sidebar['lg_admin_payout_list']) : 'Payout List';  ?>
										</span>
									</a>
								</li>
							<?php } ?>
						</ul>
					</li>
				<?php }
				if (in_array(10, $access_result_data_array) && settingValue('wallet_option') == 1) {  ?>
					<li class="<?php echo ($active == 'wallet' || $active == 'wallet-history' || $active == 'wallet-request-history') ? 'active' : ''; ?>">
						<a href="<?php echo $base_url; ?>admin/wallet"><i class="fas fa-wallet"></i><span> <?php echo (!empty($sidebar['lg_admin_wallet'])) ? ($sidebar['lg_admin_wallet']) : 'Wallet';  ?></span></a>
					</li>
				<?php } ?>

				<?php if (in_array(48, $access_result_data_array)) { ?>
					<li class="<?php echo ($page == 'refund-request-list') ? 'active' : ''; ?>">
						<a href="<?php echo $base_url; ?>refund-request-list"><i class="fas fa-money-check"></i>
							<span>
								<?php echo (!empty($sidebar['lg_admin_refund_request'])) ? ($sidebar['lg_admin_refund_request']) : 'Refund Request';  ?>
							</span>
						</a>
					</li>
				<?php } ?>
				<?php if (in_array(27, $access_result_data_array) || in_array(28, $access_result_data_array) || in_array(29, $access_result_data_array)) { ?>
					<li class="menu-title">
						<span>
							<?php echo (!empty($sidebar['lg_admin_Others'])) ? ($sidebar['lg_admin_Others']) : 'Others';  ?>
						</span>
					</li>
					<li class="submenuu <?php echo ($active == 'chat' || $page == 'provider-chat' || $page == 'client-chat') ? 'active' : ''; ?>">
						<a href="<?php echo $base_url; ?>admin/chat"><i class="fas fa-comments"></i> <span><?php echo (!empty($sidebar['lg_admin_chat'])) ? ($sidebar['lg_admin_chat']) : 'Chat';  ?></span></a>
					</li>
				<?php } ?>
				<?php if (in_array(50, $access_result_data_array) || in_array(51, $access_result_data_array) || in_array(52, $access_result_data_array)) { ?>
					<li class="menu-title">
						<span>
							<?php echo (!empty($sidebar['lg_admin_content'])) ? ($sidebar['lg_admin_content']) : 'Content';  ?>
						</span>
					</li>
					<li class="submenu">
						<a href="#"><i class="fas fa-book"></i>
							<span>
								<?php echo (!empty($sidebar['lg_admin_pages'])) ? ($sidebar['lg_admin_pages']) : 'Pages';  ?>
							</span>
							<span class="menu-arrow"><i class="fas fa-angle-right"></i></span></a>
						<ul>
							<?php if (in_array(50, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'add-pages') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/add-pages"><span>
											<?php echo (!empty($sidebar['lg_admin_add_pages'])) ? ($sidebar['lg_admin_add_pages']) : 'All Pages';  ?>
										</span></a>
								</li>
							<?php } ?>
							<?php if (in_array(50, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'pages-list' || $active == 'edit-pages') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/pages-list"><span>
											<?php echo (!empty($sidebar['lg_admin_pages_list'])) ? ($sidebar['lg_admin_pages_list']) : 'Page List';  ?>
										</span></a>
								</li>
							<?php }
							if (in_array(41, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'pages' || $active == 'home-page' || $active == 'about-us' || $active == 'cookie-policy' || $active == 'faq' || $active == 'help' || $active == 'privacy-policy' || $active == 'terms-service') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/pages"> <span><?php echo (!empty($sidebar['lg_admin_pages'])) ? ($sidebar['lg_admin_pages']) : 'Pages';  ?> </span></a>
								</li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
				<?php if (in_array(53, $access_result_data_array) || in_array(54, $access_result_data_array) || in_array(55, $access_result_data_array) || in_array(56, $access_result_data_array)) { ?>
					<li class="submenu">
						<a href="#"><i class="fa fa-newspaper"></i>
							<span>
								<?php echo (!empty($sidebar['lg_admin_blog_title'])) ? ($sidebar['lg_admin_blog_title']) : 'Blogs';  ?>
							</span>
							<span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
						</a>
						<ul>
							<?php if (in_array(56, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($page == 'blogs') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>blogs">
										<?php echo (!empty($sidebar['lg_admin_all_blog'])) ? ($sidebar['lg_admin_all_blog']) : 'All Blogs';  ?>
									</a>
								</li>
							<?php }
							if (in_array(53, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($page == 'add-blog' || $page == 'edit-blog') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>add-blog">
										<?php echo (!empty($sidebar['lg_admin_add_blog'])) ? ($sidebar['lg_admin_add_blog']) : 'Add Blogs';  ?>
									</a>
								</li>
							<?php }
							if (in_array(54, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($page == 'blog-categories' || $page == 'edit-blog-category' || $page == 'add-blog-category') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>blog-categories">
										<?php echo (!empty($sidebar['lg_admin_category_name'])) ? ($sidebar['lg_admin_category_name']) : 'Categories';  ?>
									</a>
								</li>
							<?php }
							if (in_array(55, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'blog-comments') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/blog-comments"><span> <?php echo (!empty($sidebar['lg_admin_blog_comments'])) ? ($sidebar['lg_admin_blog_comments']) : 'Blog Comments';  ?></span></a>
								</li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
				<?php if (in_array(57, $access_result_data_array) || in_array(58, $access_result_data_array) || in_array(59, $access_result_data_array)) { ?>
					<li class="submenu">
						<a href="#">
							<i class="fas fa-location-arrow"></i>
							<span>
								<?php echo (!empty($sidebar['lg_admin_location'])) ? ($sidebar['lg_admin_location']) : 'Location';  ?>
							</span>
							<span class="menu-arrow"><i class="fas fa-angle-right"></i>
							</span>
						</a>
						<ul>
							<?php if (in_array(57, $access_result_data_array)) { ?>
								<li>
									<a href="<?php echo $base_url; ?>admin/country-code-config" class="<?php echo ($active == 'country-code-config' || $page == 'add-country' || $page == 'edit-country') ? 'active' : ''; ?>">
										<span>
											<?php echo (!empty($sidebar['lg_admin_Countries'])) ? ($sidebar['lg_admin_Countries']) : 'Countries';  ?>
										</span>
									</a>
								</li>
							<?php }
							if (in_array(58, $access_result_data_array)) { ?>
								<li>
									<a href="<?php echo $base_url; ?>state-list" class="<?php echo ($page == 'state-list' || $page == 'add-state' || $page2 == 'edit_state') ? 'active' : ''; ?>">
										<span>
											<?php echo (!empty($sidebar['lg_admin_States'])) ? ($sidebar['lg_admin_States']) : 'States';  ?>
										</span>
									</a>
								</li>
							<?php }
							if (in_array(59, $access_result_data_array)) { ?>
								<li>
									<a href="<?php echo $base_url; ?>city-list" class="<?php echo ($page == 'city-list' || $page == 'add-city' || $page2 == 'edit-city') ? 'active' : ''; ?>">
										<span>
											<?php echo (!empty($sidebar['lg_admin_Cities'])) ? ($sidebar['lg_admin_Cities']) : 'Cities';  ?>
										</span>
									</a>
								</li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
				<?php if (in_array(9, $access_result_data_array) || in_array(60, $access_result_data_array)) { ?>
					<li class="menu-title">
						<span>
							<?php echo (!empty($sidebar['lg_admin_Membership'])) ? ($sidebar['lg_admin_Membership']) : 'Membership';  ?>
						</span>
					</li>
					<li class="submenu">
						<a href="#"><i class="fas fa-clipboard"></i>
							<span>
								<?php echo (!empty($sidebar['lg_admin_Membership'])) ? ($sidebar['lg_admin_Membership']) : 'Membership';  ?>
							</span>
							<span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
						</a>
						<ul>
							<?php if (in_array(9, $access_result_data_array)) { ?>
								<li>
									<a href="<?php echo $base_url; ?>subscriptions" class="<?php echo ($page == 'subscriptions') ? 'active' : '';
																							echo ($page == 'add-subscription') ? 'active' : '';
																							echo ($page == 'edit-subscription') ? 'active' : ''; ?>"> <span><?php echo (!empty($sidebar['lg_admin_subscriptions'])) ? ($sidebar['lg_admin_subscriptions']) : 'Subscriptions';  ?></span></a>
								</li>
							<?php }
							if (in_array(60, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'subscription-transactions') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/subscription-transactions"> <span>
											<?php echo (!empty($sidebar['lg_admin_transactions'])) ? ($sidebar['lg_admin_transactions']) : 'Transactions';  ?></span></a>
								</li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
				<?php if (in_array(43, $access_result_data_array) || in_array(44, $access_result_data_array) || in_array(11, $access_result_data_array) || in_array(18, $access_result_data_array)) { ?>
					<li class="menu-title">
						<span>
							<?php echo (!empty($sidebar['lg_admin_Reports'])) ? ($sidebar['lg_admin_Reports']) : 'Reports';  ?>
						</span>
					</li>
					<li class="submenu  <?php echo ($active == 'earnings' || $active == 'seller-balance') ? 'active' : ''; ?>">
						<a href="#"><i class="fas fa-wallet"></i> <span>
								<?php echo (!empty($sidebar['lg_admin_Earnings'])) ? ($sidebar['lg_admin_Earnings']) : 'Earnings';  ?>
							</span> <span class="menu-arrow"><i class="fas fa-angle-right"></i></span></a>
						<ul>
							<?php if (in_array(43, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($page == 'earnings') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>earnings"><span> <?php echo (!empty($sidebar['lg_admin_Earnings'])) ? ($sidebar['lg_admin_Earnings']) : 'Earnings';  ?></span></a>
								</li>
							<?php }
							if (in_array(44, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'seller-balance') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/seller-balance"><span> <?php echo (!empty($sidebar['lg_admin_Seller_Balance'])) ? ($sidebar['lg_admin_Seller_Balance']) : 'Seller Balance';  ?></span></a>
								</li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
				<?php if (in_array(11, $access_result_data_array)) { ?>
					<li class="<?php echo ($page == 'revenue') ? 'active' : ''; ?>">
						<a href="<?php echo $base_url; ?>revenue"> <i class="fas fa-bullhorn"></i> <span><?php echo (!empty($sidebar['lg_admin_revenue'])) ? ($sidebar['lg_admin_revenue']) : 'Revenue';  ?></span></a>
					</li>
				<?php }
				if (in_array(18, $access_result_data_array)) { ?>
					<li class="<?php echo ($active == 'cod') ? 'active' : ''; ?>">
						<a href="<?php echo $base_url; ?>admin/cod"> <i class="fas fa-code"></i> <span><?php echo (!empty($sidebar['lg_admin_cod'])) ? ($sidebar['lg_admin_cod']) : 'COD';  ?></span></a>
					</li>
				<?php } ?>

				<?php if (in_array(1, $access_result_data_array) || in_array(13, $access_result_data_array) || in_array(12, $access_result_data_array) || in_array(49, $access_result_data_array) || in_array(72, $access_result_data_array)) { ?>
					<li class="menu-title">
						<span>
							<?php echo (!empty($sidebar['lg_admin_user_management'])) ? ($sidebar['lg_admin_user_management']) : 'User Management';  ?>
						</span>
					</li>
					<li class="submenu <?php echo ($page == 'adminusers') ? 'active' : '';
										echo ($page == 'edit_adminuser') ? 'active' : '';
										echo ($page == 'adminuser_details') ? 'active' : '';
										echo ($page == 'users') ? 'active' : '';
										echo ($page == 'service-providers') ? 'active' : '';
										echo ($page == 'user-details') ? 'active' : '';
										echo ($page == 'provider-details') ? 'active' : ''; ?>">
						<a href="#">
							<i class="fas fa-users"></i> <span><?php echo (!empty($sidebar['lg_admin_user_settings'])) ? ($sidebar['lg_admin_user_settings']) : 'Manage Users';  ?> </span> <span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
						</a>
						<ul>
							<?php
							if (in_array(1, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($page == 'adminusers') ? 'active' : '';
												echo ($page == 'edit_adminuser') ? 'active' : '';
												echo ($page == 'adminuser_details') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>adminusers"><span><?php echo (!empty($sidebar['lg_admin_admin'])) ? ($sidebar['lg_admin_admin']) : 'Administrators';  ?></span></a>
								</li>
							<?php
							}
							if (in_array(12, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($page == 'service-providers') ? 'active' : '';
												echo ($page == 'provider-details') ? 'active' : '';
												echo ($page == 'providers') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>service-providers"> <span> <?php echo (!empty($sidebar['lg_admin_service_providers'])) ? ($sidebar['lg_admin_service_providers']) : 'Providers';  ?></span></a>
								</li>
							<?php }
							if (in_array(13, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($page == 'users') ? 'active' : '';
												echo ($page == 'user-details') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>users"> <span><?php echo (!empty($sidebar['lg_admin_users'])) ? ($sidebar['lg_admin_users']) : 'Users';  ?></span></a>
								</li>
								<?php
								}  ?>
							</ul>
						</li>
					<?php } ?>
					<?php if(in_array(49,$access_result_data_array)) { ?>
						<li class="<?php echo ($active == 'roles' || $active == 'edit-roles-permissions' || $active == 'add-roles-permissions')?'active':'';?>">
							<a href="<?php echo $base_url; ?>admin/roles"><i class="fas fa-key"></i> <span><?php echo(!empty($sidebar['lg_admin_roles_permissions']))?($sidebar['lg_admin_roles_permissions']) : 'Roles & Permissions';  ?></span></a>
						</li> 
					<?php } ?>
					<?php if(in_array(80,$access_result_data_array)) { ?>
						<!-- <li class="<?php echo ($active == 'admin/verification-request')?'active':'';?>">
							<a href="<?php echo $base_url; ?>admin/verification-request"><i class="fas fa-key"></i> <span><?php echo(!empty($sidebar['lg_admin_roles_permissions']))?($sidebar['lg_admin_roles_permissions']) : 'Verification Request';  ?></span></a>
						</li>  -->
					<?php } ?>
					<?php if(in_array(17,$access_result_data_array) || in_array(20,$access_result_data_array) || in_array(61,$access_result_data_array) || in_array(62,$access_result_data_array)) { ?>
					<li class="menu-title">
						<span>
							<?php echo (!empty($sidebar['lg_admin_management'])) ? ($sidebar['lg_admin_management']) : 'Management';  ?>
						</span>
					</li>
					<?php if (in_array(61, $access_result_data_array)) { ?>
						<li class="<?php echo ($active == 'cache-settings') ? 'active' : ''; ?>">
							<a href="<?php echo $base_url; ?>admin/cache-settings"> <i class="fas fa-window-restore"></i> <span><?php echo (!empty($sidebar['lg_admin_cache_settings'])) ? ($sidebar['lg_admin_cache_settings']) : 'Cache System';  ?></span></a>
						</li>
					<?php }
					if (in_array(17, $access_result_data_array)) { ?>
						<li class="<?php echo ($active == 'contact' || $page == 'contact-details') ? 'active' : ''; ?>">
							<a href="<?php echo $base_url; ?>admin/contact"><i class="fas fa-paper-plane"></i> <span> <?php echo (!empty($sidebar['lg_admin_contact_messages'])) ? ($sidebar['lg_admin_contact_messages']) : 'Contact Messages';  ?></span></a>
						</li>
					<?php }
					if (in_array(20, $access_result_data_array)) { ?>
						<li class="<?php echo ($active == 'emailtemplate' || $page == 'edit-emailtemplate') ? 'active' : ''; ?>">
							<a href="<?php echo $base_url; ?>admin/emailtemplate"><i class="fas fa-envelope"></i> <span> <?php echo (!empty($sidebar['lg_admin_email_templates'])) ? ($sidebar['lg_admin_email_templates']) : 'Email Templates';  ?></span></a>
						</li>
					<?php }
					if (in_array(62, $access_result_data_array)) { ?>
						<li class="<?php echo ($active == 'abuse-reports' || $page == 'abuse-details') ? 'active' : ''; ?>">
							<a href="<?php echo $base_url; ?>admin/abuse-reports"><i class="fas fa-file"></i>
								<span>
									<?php echo (!empty($sidebar['lg_admin_abuse_report'])) ? ($sidebar['lg_admin_abuse_report']) : 'Abuse Reports';  ?>
								</span>
							</a>
						</li>
				<?php }
				} ?>
				<?php if (in_array(19, $access_result_data_array)) { ?>
					<li class="<?php echo ($active == 'announcements' || $active == 'send-announcements') ? 'active' : ''; ?>">
						<a href="<?php echo $base_url; ?>admin/announcements"><i class="fa fa-bell"></i> <span> <?php echo (!empty($sidebar['lg_admin_push_notifications'])) ? ($sidebar['lg_admin_push_notifications']) : 'Announcements';  ?></span></a>
					</li>
				<?php } ?>
				<?php if (in_array(27, $access_result_data_array) || in_array(42, $access_result_data_array) || in_array(28, $access_result_data_array) || in_array(29, $access_result_data_array) || in_array(30, $access_result_data_array) || in_array(31, $access_result_data_array) || in_array(32, $access_result_data_array) || in_array(33, $access_result_data_array) || in_array(63, $access_result_data_array) || in_array(64, $access_result_data_array) || in_array(38, $access_result_data_array) || in_array(35, $access_result_data_array) || in_array(37, $access_result_data_array) || in_array(39, $access_result_data_array) || in_array(40, $access_result_data_array) || in_array(34, $access_result_data_array) || in_array(65, $access_result_data_array) || in_array(66, $access_result_data_array) || in_array(67, $access_result_data_array)) { ?>
					<li class="menu-title">
						<span>
							<?php echo (!empty($sidebar['lg_admin_settings'])) ? ($sidebar['lg_admin_settings']) : 'Settings';  ?>
						</span>
					</li>
					<li class="submenu <?php echo ($active == 'general-settings' || $active == 'localization' || $page == 'admin-profile') ? 'active' : ''; ?>">
						<a href="#">
							<i class="fas fa-sliders-h"></i> <span><?php echo (!empty($sidebar['lg_admin_general_settings'])) ? ($sidebar['lg_admin_general_settings']) : 'General Settings';  ?></span> <span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
						</a>
						<ul>
							<?php
							if (in_array(27, $access_result_data_array)) {
							?>
								<li>
									<a class="<?php echo ($active == 'general-settings') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/general-settings"> <span><?php echo (!empty($sidebar['lg_admin_general_settings'])) ? ($sidebar['lg_admin_general_settings']) : 'General Settings';  ?></span></a>
								</li>
							<?php }
							if (in_array(28, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'localization') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/localization"> <span><?php echo (!empty($sidebar['lg_admin_localization'])) ? ($sidebar['lg_admin_localization']) : 'Localization';  ?></span></a>
								</li>
							<?php }
							if (in_array(64, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($page == 'admin-profile') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin-profile"> <span><?php echo (!empty($sidebar['lg_admin_profile'])) ? ($sidebar['lg_admin_profile']) : 'Manage Profile';  ?></span></a>
								</li>
							<?php } ?>
						</ul>
					</li>
					<?php if (in_array(32, $access_result_data_array) || in_array(34, $access_result_data_array) || in_array(39, $access_result_data_array) || in_array(40, $access_result_data_array) || in_array(29, $access_result_data_array)  || in_array(38, $access_result_data_array) || in_array(35, $access_result_data_array) || in_array(67, $access_result_data_array)) { ?>
						<li class="submenu <?php echo ($active == 'seo-settings' || $active == 'theme-color' || $active == 'frontend-settings' || $active == 'footer-settings' || $active == 'social-settings' || $active == 'chat-settings' || $page == 'languages' || $page == 'wep_language' || $page == 'app-page-list' || $page == 'add-app-keyword' || $page == 'add-languages' || $page == 'admin-web-languages' || $page == 'web-languages' || $page == 'edit-languages' || $page == 'add-wep-keyword' || $page == 'add-admin-keyword' || $active == 'sitemap' || $page == "languages-new") ? 'active' : ''; ?>">
							<a href="#">
								<i class="fas fa-cog"></i>
								<span>
									<?php echo (!empty($sidebar['lg_admin_website_settings'])) ? ($sidebar['lg_admin_website_settings']) : 'Website Settings';  ?>
								</span> <span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
							</a>
							<ul>
								<?php if (in_array(32, $access_result_data_array)) { ?>
									<li>
										<a class="<?php echo ($active == 'seo-settings') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/seo-settings"> <span><?php echo (!empty($sidebar['lg_admin_seo_settings'])) ? ($sidebar['lg_admin_seo_settings']) : 'Seo Settings';  ?></span></a>
									</li>
								<?php }
								if (in_array(34, $access_result_data_array)) { ?>
									<li>
										<a class="<?php echo ($active == 'theme-color') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/theme-color"> <span><?php echo (!empty($sidebar['lg_admin_theme_settings'])) ? ($sidebar['lg_admin_theme_settings']) : 'Theme Settings';  ?></span></a>
									</li>
								<?php } ?>
								<li>
									<a class="submenu <?php echo ($active == 'frontend-settings' || $active == 'footer-settings') ? 'active' : ''; ?>" href="#">
										<span>
											<?php echo (!empty($sidebar['lg_admin_frontend_settings'])) ? ($sidebar['lg_admin_frontend_settings']) : 'Frontend Settings';  ?>
										</span>
										<span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
									</a>
									<ul>
										<?php if (in_array(39, $access_result_data_array)) { ?>
											<li>
												<a class="<?php echo ($active == 'frontend-settings') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/frontend-settings"> <span><?php echo (!empty($sidebar['lg_admin_header_settings'])) ? ($sidebar['lg_admin_header_settings']) : 'Header Settings';  ?></span></a>
											</li>
										<?php }
										if (in_array(40, $access_result_data_array)) { ?>
											<li>
												<a class="<?php echo ($active == 'footer-settings') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/footer-settings"> <span><?php echo (!empty($sidebar['lg_admin_footer_settings'])) ? ($sidebar['lg_admin_footer_settings']) : 'Footer Settings';  ?></span></a>
											</li>
										<?php } ?>
									</ul>
								</li>
								<?php if (in_array(29, $access_result_data_array)) { ?>
									<li>
										<a class="<?php echo ($active == 'social-settings') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/social-settings"> <span><?php echo (!empty($sidebar['lg_admin_login_settings'])) ? ($sidebar['lg_admin_login_settings']) : 'Login Settings';  ?></span></a>
									</li>
								<?php }
								if (in_array(38, $access_result_data_array)) { ?>
									<li>
										<a class="<?php echo ($active == 'chat-settings') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/chat-settings"> <span><?php echo (!empty($sidebar['lg_admin_chat_settings'])) ? ($sidebar['lg_admin_chat_settings']) : 'Chat Settings';  ?></span></a>
									</li>
								<?php }
								if (in_array(35, $access_result_data_array)) { ?>
								<?php }
								if (in_array(35, $access_result_data_array)) { ?>
									<li>
										<a class="<?php echo ($page == 'languages-settings' || $page == 'wep_language' || $page == 'app-page-list' || $page == 'add-app-keyword' || $page == 'add-languages' || $page == 'admin-web-languages' || $page == 'web-languages' || $page == 'edit-languages' || $page == 'add-wep-keyword' || $page == 'add-admin-keyword') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>languages-settings"> <span><?php echo (!empty($sidebar['lg_admin_language'])) ? ($sidebar['lg_admin_language']) : 'Language Settings';  ?></span></a>
									</li>
								<?php }
								if (in_array(67, $access_result_data_array)) { ?>
									<li>
										<a class="<?php echo ($active == 'sitemap') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/sitemap">
											<span>
												<?php echo (!empty($sidebar['lg_admin_sitemap'])) ? ($sidebar['lg_admin_sitemap']) : 'Sitemap';  ?>
											</span>
										</a>
									</li>
								<?php } ?>
							</ul>
						</li>
					<?php } ?>
				<?php } ?>
				<?php if (in_array(42, $access_result_data_array) || in_array(30, $access_result_data_array) || in_array(33, $access_result_data_array) || in_array(37, $access_result_data_array)) { ?>
					<li class="submenu <?php echo ($active == 'system-settings' || $active == 'emailsettings' || $active == 'sms-settings' || $active == 'footer-settings') ? 'active' : ''; ?>">
						<a href="#">
							<i class="fas fa-cog"></i> <span><?php echo (!empty($sidebar['lg_admin_system_settings'])) ? ($sidebar['lg_admin_system_settings']) : 'System Settings';  ?></span> <span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
						</a>
						<ul>
							<?php if (in_array(42, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'system-settings') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/system-settings"> <span><?php echo (!empty($sidebar['lg_admin_system_settings'])) ? ($sidebar['lg_admin_system_settings']) : 'System Settings';  ?></span></a>
								</li>
							<?php }
							if (in_array(30, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'emailsettings') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/emailsettings"> <span><?php echo (!empty($sidebar['lg_admin_email_settings'])) ? ($sidebar['lg_admin_email_settings']) : 'Email Settings';  ?></span></a>
								</li>
							<?php } ?>
							<?php if (in_array(33, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'sms-settings') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/sms-settings"> <span><?php echo (!empty($sidebar['lg_admin_smssettings'])) ? ($sidebar['lg_admin_smssettings']) : 'SMS Settings';  ?></span></a>
								</li>
							<?php }
							if (in_array(37, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'other-settings') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/other-settings"> <span><?php echo (!empty($sidebar['lg_admin_other_settings'])) ? ($sidebar['lg_admin_other_settings']) : 'Other Settings';  ?></span></a>
								</li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>

				<?php if (in_array(66, $access_result_data_array) || in_array(30, $access_result_data_array) || in_array(65, $access_result_data_array) || in_array(78, $access_result_data_array)) { ?>
					<li class="submenu">
						<a href="#">
							<i class="fas fa-money-bill"></i>
							<span>
								<?php echo (!empty($sidebar['lg_admin_financial_settings'])) ? ($sidebar['lg_admin_financial_settings']) : 'Financial Settings';  ?>
							</span>
							<span class="menu-arrow"><i class="fas fa-angle-right"></i></span>
						</a>
						<ul>
							<?php if (in_array(30, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'stripe-payment-gateway' || $active == 'razorpay-payment-gateway' || $active == 'paypal-payment-gateway' || $active == 'paystack-payment-gateway' || $active == 'paysolution-payment-gateway' || $active == 'cod-payment-gateway' || $active == 'wallet-payment-gateway' || $active == "offlinepayment" || $active == "midtrans-payment-gateway" || $active == "flutter-payment-gateway" || $active == "iyzico-payment-gateway") ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/stripe-payment-gateway"> <span><?php echo (!empty($sidebar['lg_admin_paymentsettings'])) ? ($sidebar['lg_admin_paymentsettings']) : 'Payment Settings';  ?></span></a>
								</li>
							<?php } ?>
							<?php if (in_array(66, $access_result_data_array)) { ?>
								<li>
									<a class="<?php echo ($active == 'offline-payment-details') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/offline-payment-details"> <span><?php echo (!empty($sidebar['lg_admin_bank_trans_offline'])) ? ($sidebar['lg_admin_bank_trans_offline']) : 'Bank Transfer (Offline)';  ?></span></a>
								</li>
								<?php if (in_array(65, $access_result_data_array)) { ?>
									<li>
										<a class="<?php echo ($active == 'currency-settings' || $page2 == 'create-currency' || $page2 == 'currency-edit') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/currency-settings"> <span><?php echo (!empty($sidebar['lg_admin_currency_settings'])) ? ($sidebar['lg_admin_currency_settings']) : 'Currency Settings';  ?></span></a>
									</li>
								<?php }
								if (in_array(78, $access_result_data_array)) { ?>
									<li>
										<a class="<?php echo ($active == 'tax-settings') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>admin/tax-settings"> <span> <?php echo (!empty($sidebar['lg_admin_Tax_Settings'])) ? ($sidebar['lg_admin_Tax_Settings']) : 'Tax Settings';  ?></span></a></span></a>
									</li>
								<?php } ?>
						</ul>
					</li>
				<?php } ?>
				<?php if (in_array(79, $access_result_data_array)) { ?>

					<li class="<?php echo ($active == 'appointment-settings') ? 'active' : ''; ?>">
						<a href="<?php echo $base_url; ?>admin/appointment-settings"> <i class="fas fa-business-time"></i> <span><?php echo (!empty($sidebar['lg_admin_appointment_settings'])) ? ($sidebar['lg_admin_appointment_settings']) : 'Appointment Settings';  ?></span></a>
					</li>
				<?php } ?>
				<?php if (in_array(63, $access_result_data_array)) { ?>
					<li class="<?php echo ($active == 'service-settings') ? 'active' : ''; ?>">
						<a href="<?php echo $base_url; ?>admin/service-settings"> <i class="fas fa-business-time"></i> <span><?php echo (!empty($sidebar['lg_admin_service_settings'])) ? ($sidebar['lg_admin_service_settings']) : 'Service Settings';  ?></span></a>
					</li>
				<?php } ?>
			<?php } ?>
			</ul>
		</div>
	</div>
</div>