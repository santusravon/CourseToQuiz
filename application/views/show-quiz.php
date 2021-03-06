<style>
.list-group-item:hover{
  background-color:#ddd;
}
</style>

<div class="container-fluid">
<br>
  <h4 style="background:#ddd">&nbsp;&nbsp;&nbsp;&nbsp;
    <span>Welcome <?php echo $this->session->userdata('displayname') ? $this->session->userdata('displayname') : "Guest";?></span></h4>
  <br>
  <div class="row">

  <div class="col-md-12">
   <?php foreach($course as $r){
     $course_title = $r['course_title'];
     $course_name = $r['course_name'];
   } ?>

    <div class="card">
  <h5 class="card-header">QUIZ - <?php echo $course_title ;?></h5>
  <div class="card-body">
    <h3 class="card-title"><?php echo $course_title ;?><span class="float-right">Time 00:15:00</span></h3>
    <h5> - <?php echo $total_questions;?> multiple choice questions available</h5>
    <h5> - 15 minutes test time</h5>
    <p class="card-text">
    <?php echo $r['course_description'];?>
    </p>
     <h5>Select Difficult Level</h5>
     <select class="btn btn-outline-secondary btn-lg selectLevel" onchange="updateNoOfQuestionWithLevels(this.value)">
       <option selected="true" disabled="disabled">Difficult Level</option>
       <option value="easy" select>Easy - Level</option>
       <option value="medium">Medium - Level</option>
       <option value="hard">Hard - Level</option>
       <option value="complex">Complex - Level</option>
     </select>
      <script>
      function updateNoOfQuestionWithLevels(i){
        var param = {
          selectLevel : i,
          coursename : '<?php echo $this->uri->segment(2);?>'
        };
        $.post('<?php echo base_url();?>home/updateNoOfQuestionWithLevels',param,function(data,status){
          if(data == 0){
            $('.no_of_questions').html('<option selected="true" disabled="disabled">Not Yet Available</option>').show();
            $('.QuizReadyConfirmation').addClass('disabled');
            $('.QuizReadyConfirmation').attr('aria-disabled="true"');
           }else{
             if($('.no_of_questions').val()){
               $('.QuizReadyConfirmation').removeClass('disabled');
               $('.QuizReadyConfirmation').attr('aria-disabled="false"');
             }
             $('.no_of_questions').html(data).show();
          }

        });
      }
      function no_of_questions(x){
          var x = parseInt(x);
        if(typeof x == 'number'){
          $('.QuizReadyConfirmation').removeClass('disabled');
          $('.QuizReadyConfirmation').attr('aria-disabled="false"');
        }else{
          $('.QuizReadyConfirmation').addClass('disabled');
          $('.QuizReadyConfirmation').attr('aria-disabled="true"');

        }
        console.log(typeof x);
      }
      </script>
     <h5>Select Number Of Questions</h5>
     <select class="btn btn-outline-secondary btn-lg selectLevel no_of_questions" name="no_of_questions" onclick="no_of_questions(this.value)">
        <option disabled="disabled">No Of Questions</option>
        <?php for($i = 1;$i<= $total_questions_level;$i++) : ?>
          <option value="<?php echo $i;?>"><?php echo $i;?></option>
        <?php endfor ?>
     </select>
  </div>
</div>
<br>
  <?php
  if($this->session->userdata('userId')){
    if(hasSubscription($this->session->userdata('userId')) == true){
      $popupDiv = "QuizReadyConfirmation";
    }else{
      $popupDiv = "SubscriptionPopup";
    }
  }else{
      $popupDiv = "QuizReadyConfirmation";
  }
  ?>

  <h4>&nbsp;&nbsp;&nbsp;</h4>
  <div class="row">
<div class="col-sm-6">
 <div class="card">
   <div class="card-body">
     <h5 class="card-title">Real Quiz on <?php echo $course_title ;?></h5>
     <p class="card-text">After taking this live quiz you will get certified and you score will be stored</p>
     <a href="javascript:void(0)" data-quiztype="1"  class="btn btn-success QuizReadyConfirmation disabled">Start Real Quiz</a>
     <span>&nbsp;&nbsp;&nbsp;Membership is required</span>
   </div>
 </div>
</div>

<div class="col-sm-6">
 <div class="card">
   <div class="card-body">
     <h5 class="card-title">Practise Quiz on <?php echo $course_title ;?></h5>
     <p class="card-text">Use this quiz option if you want to practise</p>
     <a href="javascript:void(0)" data-quiztype="0" class="btn btn-warning QuizReadyConfirmation disabled">Go Test Quiz</a>
   </div>
 </div>
</div>
</div>
<br>

  </div>
</div>
<input type="hidden" id="courseSelected" value="<?php echo $course_name;?>" />
</div>
<br><br>
<div class="modal fade" id="startQuizPop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you ready to start this quiz ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <h4>Quiz About <?php echo $course_name;?> </h4>
       <h5> - Time limit 15 min<br> - <span id="selectedQuestionCount"></span> Questions</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Later</button>
        <a href="#" class="btn btn-success confirmQuizLink">Yes,I'm ready</a>
      </div>
    </div>
  </div>
</div>
