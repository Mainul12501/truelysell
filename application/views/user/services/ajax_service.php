<?php

	$query = $this->db->query("select * from system_settings WHERE status = 1");

	$result = $query->result_array();

	if(!empty($result))

		{

		foreach($result as $data){

			if($data['key'] == 'currency_option'){

				$currency_option = $data['value'];

			}

		}

	}



	if(!empty($service)) {

		foreach ($service as $srows) {

            $output =  preg_replace('/[^A-Za-z0-9-]+/', '-', $srows['service_title']);

            $serv_url = str_replace(" ","-",trim($output));

            $inputs['url'] = strtolower($serv_url);
            
            $ser_url = ($srows['url'])?$srows['url']:$inputs['url'];

            $data = array('url'=>$ser_url);

            if(empty($srows['url'])) {

                $this->db->update('services', $data, array('id'=>$srows['id']));
            }

			$provider_details = $this->db->where('id',$srows['user_id'])->get('providers')->row_array();

			$serviceimage=explode(',', $srows['service_image']);



			$this->db->select('AVG(rating)');

			$this->db->where(array('service_id'=>$srows['id'],'status'=>1));

			$this->db->from('rating_review');

			$rating = $this->db->get()->row_array();

			$avg_rating = round($rating['AVG(rating)'],1);

            $this->db->select('id,user_id,status,service_id');

            $this->db->where('user_id', $this->session->userdata('id'));

            $this->db->where('provider_id', $srows['user_id']);

            $this->db->where('service_id', $srows['id']);

            $this->db->from('user_favorite');

            $query = $this->db->get();



            if($query !== FALSE && $query->num_rows() > 0){

                $user_fav = $query->row_array();

            }

			$service_amount = $srows['service_amount'];

			$userId = $this->session->userdata('id');

			If (empty($userId)) {

			$user_currency_code = settings('currency');

			$service_currency_code = $srows['currency_code'];

			$service_amount = get_gigs_currency($srows['service_amount'], $srows['currency_code'], $user_currency_code);

			}

            if (is_nan($service_amount) || is_infinite($service_amount)) {

                $service_amount = $srows['service_amount'];

            }

			$serviceimages=$this->db->where('service_id',$srows['id'])->get('services_image')->row_array();

			

            $placholder_img = $this->db->get_where('system_settings', array('key'=>'service_placeholder_image'))->row()->value;
            
            $ser_img = base_url().'assets/img/service-placeholder.jpg';
            if (isset($serviceimages['service_image']) && file_exists($serviceimages['service_image'])) {
                $ser_img = base_url().$serviceimages['service_image'];
            }

            $profile_img = base_url().(($placholder_img&&file_exists($placholder_img))?$placholder_img:'assets/img/user.jpg');
            if (isset($provider_details['profile_img']) && file_exists($provider_details['profile_img'])) {
                $profile_img = base_url().$provider_details['profile_img'];
            }


			

		?>

		

                                <div class="col-lg-4 col-md-6 contant">
                                    
                                    <div class="service-widget">

                                        <div class="service-img">

                                            <a href="<?php echo base_url() . 'service-preview/' . $srows['url']; ?>">
                                                <img class="img-fluid serv-img" alt="Service Image" src="<?php echo $ser_img; ?>">
                                            </a>

                                            <div class="item-info">
                                                <div class="service-user">
                                                        <img src="<?php echo $profile_img; ?>">
                                                        <span class="service-price"><?php echo currency_conversion($user_currency_code) . $service_amount; ?></span>
                                                </div>
                                                <div class="cate-list"> <a class="bg-yellow" href="<?php $cat_name = str_replace('&', '_', strtolower($srows['category_name'])); echo base_url() . 'search/' . str_replace(' ', '-', strtolower($cat_name)); ?>"><?php echo ucfirst($srows['category_name']); ?></a></div>

                                            </div>

                                        </div>

                                        <div class="service-content">

                                            <h3 class="title">
                                                <?php 
                                                    $ser_lang = ($this->session->userdata('user_select_language'))?$this->session->userdata('user_select_language'):'en';
                                                    $this->db->where('service_id', $srows['id']);
                                                    $this->db->where('lang_type', $ser_lang);
                                                    $service_name = $this->db->get('service_lang')->row_array();
                                                ?>
                                                <a href="<?php echo base_url() . 'service-preview/' . $srows['url']; ?>"><?php echo ucfirst($service_name['service_name']??""); ?></a>

                                                <?php    

                                                

                                                if($this->session->userdata('usertype') != "provider") {

                                                    if($userId && ($userId == $user_fav['user_id']) && $user_fav['service_id'] == $srows['id']) {

                                                        if($user_fav['status'] == 1) { ?>

                                                            <a href="javascript:;" id="ufav<?=$srows['id']?>" class="hearting flo-right-color" data-id="<?php echo $user_fav['id']?>" data-userid = "<?php echo $userId?>" data-provid="<?php echo $srows['user_id']?>" data-servid="<?php echo $srows['id']?>" data-favstatus="0" data-pagename="<?php echo $srows['category_name']?>"><i class="fas fa-heart filled"></i></a>

                                                        <?php } 

                                                        else { ?>

                                                            <a href="javascript:;" id="ufav<?=$srows['id']?>" class="hearting flo-right" data-id="<?php echo $user_fav['id']?>" data-userid = "<?php echo $userId?>" data-provid="<?php echo $srows['user_id']?>" data-servid="<?php echo $srows['id']?>" data-favstatus="1" data-pagename="<?php echo $srows['category_name']?>"><i class="fas fa-heart"></i></a>

                                                        <?php } 

                                                    } else { ?>

                                                        <a href="javascript:;" id="ufav<?=$srows['id']?>" class="hearting flo-right" data-id="<?php echo $user_fav['id']?>" data-userid = "<?php echo $this->session->userdata('id');?>" data-provid="<?php echo $srows['user_id']?>" data-servid="<?php echo $srows['id']?>" data-favstatus="1" data-pagename="<?php echo $srows['category_name']?>"><i class="fas fa-heart"></i></a>

                                                    <?php }

                                                }

                                                ?>

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



                                </div>

<?php } }

else { 

	echo '<div class="col-lg-12">

		<p class="mb-0">No Services Found</p>

	</div>';

} 

?>

<div class="pagination">

</div>




<script src="<?php echo base_url();?>assets/js/user_pagination.js"></script>
		<script src="<?php echo base_url();?>assets/js/functions.js"></script>