
</div>
            <div class="col-lg-4 border-left">
              <h4><b>Recent Blogs</b></h4>
                   <hr>
                   <?php 
                    $qry_blogs =$conn->query("SELECT * FROM `blogs` where `status` = 1 order by unix_timestamp(`date_created`) desc Limit 10");
                    while($row = $qry_blogs->fetch_assoc()):
                   ?>
                   <a href="<?php echo base_url.$row['blog_url'] ?>" class="w-100 d-flex pl-0 row-cols-2 text-decoration-none bg-light bg-gradient rounded-1 border-light border recent-item mb-1">
                       <div class="col-auto w-25 ml-0 p-0">
                           <img src="<?php echo validate_image($row['banner_path']) ?>" alt="Title" class="img-thumbnail recent-blog-img border-0 rounded-0  ml-0">
                       </div>
                       <div class="col-auto flex-grow-1 w-75">
                           <p class="truncate-1 m-0 "><b><?php echo $row['title'] ?></b></p>
                           <small class="truncate-1"><?php echo $row['meta_description'] ?></small>
                       </div>
                   </a>
                   <?php
                   endwhile;
                    ?>
                    <?php if($qry_blogs->num_rows <=0): ?>
                        <center><small><i>No data listed yet.</i></small></center>
                    <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php require_once(base_app.'inc/page_footer.php') ?>
<div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog   rounded-0 modal-md modal-dialog-centered" role="document">
      <div class="modal-content  rounded-0">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog  rounded-0 modal-full-height  modal-md" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>

</body>