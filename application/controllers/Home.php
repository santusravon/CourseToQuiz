<?php
 class Home extends CI_Controller{



   function __construct(){
     parent::__construct();
     $this->load->model('courses_model');
     $this->load->model('quiz_model');
     $this->load->model('crud_model');
     $this->load->model('report_model');
     $this->load->helper('subscription');
     $this->load->helper('common');
   }


   function index(){
      $courses = $this->courses_model->trendingCoursesByCategory();
      $this->load->view('template/content',[
        'page' => 'landing',
        'courses' => $courses,
        'total_course' => $this->report_model->total_course(),
        'total_quiz' => $this->report_model->total_quiz(),
        'total_member' => $this->report_model->total_user()
      ]);
   }



   function browse_course(){
     if(@$_GET['category']){
       $courses = $this->courses_model->coursesByCategory(@$_GET['category']);
     }else{
       $courses = $this->courses_model->trendingCoursesByCategory();
     }
      $this->load->view('template/content',[
        'page' => 'browse-course',
        'categories' => $this->crud_model->getAllRecord('category'),
        'courses' => $courses
      ]);
   }




   function show_course(){
     if($this->uri->segment(2)){
       $course = $this->courses_model->oneCourseFromName($this->uri->segment(2));
     }
      $this->load->view('template/content',[
        'page' => 'show-course',
        'course' => $course
      ]);
   }



   function browse_quiz(){
        $this->load->view('template/content',['page' => 'browse-quiz']);
   }



   function membership_plan(){
     $this->load->view('template/content',[
       'page' => 'membership-plan'
     ]);
   }


   function searchCourseByCategoryAjax(){
      $out = $this->courses_model->searchCourseByCategoryAjax($this->input->post('category'),$this->input->post('text'));
      if(is_array($out)){
        foreach($out as $r){
          echo '<a href="'.base_url().'browse-course/?course='.$r['course_name'].'"><li class="list-group-item courseSelected">'.$r['course_title'].'</li></a>';
        }
      }else{
         echo '<li class="list-group-item">No Course Found</li>';
      }
   }



   function show_quiz(){
      if($this->uri->segment(2)){
         $course = $this->courses_model->oneCourseFromName($this->uri->segment(2));
      }
      $data['total_questions'] = $this->quiz_model->total_questions($this->uri->segment(2));
      $this->load->view('template/content',array_merge([
        'page' => 'show-quiz',
        'course' => $course
      ],$data));
   }



   function start_quiz(){
     if(!$this->session->userdata('userId')){
       $this->session->set_userdata('redirectAfterLogin',base_url().'start-quiz/?'.$_SERVER['QUERY_STRING']);
       redirect('auth/login');
     }
     $this->session->unset_userdata('redirectAfterLogin');
     // Starting Quiz
     $quiz_session_id = md5(rand(1,9999).time());
     $quizData = [
       'quiz_session_id' => $quiz_session_id,
       'level'    => $_GET['level'],
       'course'   => $_GET['course'],
       'quizType' => $_GET['QuizType'],
       'noOfQuestions' => $_GET['noOfQuestions']
     ];
     $this->session->set_userdata($quizData);
     $this->crud_model->create('quiz',[
       'quiz_session_id' => $quiz_session_id,
       'quiz_title' => 'quiz started',
       'quiz_name'  => 'quiz-started',
       'user_id'    => $this->session->userdata('userId'),
       'course_id'  => $this->quiz_model->getCourseIdFromCourseName($_GET['course']),
       'jsonData'   => json_encode($quizData,true),
       'created'    => date('d-m-Y h:i:s'),
       'updated'    => date('d-m-Y h:i:s'),
       'status'     => 1
     ]);

     $this->load->view('template/content',[
       'page'      => 'start-quiz',
       'quizData'  => $quizData,
       'quizDuration' => 15,
       'totalQuestions'  => $_GET['noOfQuestions']
     ]);
   }


  function license(){
    $this->load->view('template/content',[
      'page'      => 'site',
      'section'   => 'license'
    ]);
  }

  function subscription(){
    $this->load->view('template/content',[
      'page'      => 'site',
      'section'   => 'subscription'
    ]);
  }

  function legal_notice(){
    $this->load->view('template/content',[
      'page'      => 'site',
      'section'   => 'legal_notice'
    ]);
  }

  function privacy_policy(){
    $this->load->view('template/content',[
      'page'      => 'site',
      'section'   => 'privacy_policy'
    ]);
  }

  function about(){
    $this->load->view('template/content',[
      'page'      => 'site',
      'section'   => 'about'
    ]);
  }

  function contact(){
    $this->load->view('template/content',[
      'page'      => 'site',
      'section'   => 'contact'
    ]);
  }

  function faq(){
    $this->load->view('template/content',[
      'page'      => 'site',
      'section'   => 'faq'
    ]);
  }




 }
?>
