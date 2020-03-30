<?php
class QuestionController extends Controller {
    protected $questionsPerPage = 3;
    protected $questions;

    function __construct() {
        parent::__construct();
    }

    function create() {
        if(count($_POST) > 0) {
            $request = $_POST;
            if($this->model->create($request)) {
                $link = getenv('website_path');
                $_SESSION['message'] = "You asked question correctly";
                header("Location:$link");
            } else {
                $_SESSION['message'] = "Something went wrong :(";
            }
        } else {
            $this->view->render(['files' => ['./views/forms/addQuestionForm.php']]);
        }  
    }

    function all($currentPage = 1) {

        //Pagination:
        $offset = ($currentPage - 1) * $this->questionsPerPage;

        //Total number of pages:
        $this->questions = $this->model->countQuestions();
        if($this->questions < 1) {
            $_SESSION['message'] = "There is no question yet. Ask One!";
        }
        $totalNumberOfPages = ceil($this->questions / $this->questionsPerPage);

        $questions = $this->model->read($offset, $this->questionsPerPage);
        $this->view->render([
            'files' => 
            [
                './views/components/question/list.php',
                './views/components/question/pagination.php'
            ], 
            'questions' => $questions,
            'currentPage' => $currentPage,
            'totalNumberOfPages' => $totalNumberOfPages
            ]);
    }

    function show($id){
        if(count($_POST) > 0) {
            //added answer
            $request = $_POST;
            if($this->model->create_answer($request, $id)) {
                $question = $this->model->show($id);
                $answers = $this->model->show_answers($id);
                $this->view->render([
                    'files' => [
                        './views/components/question/detail.php', 
                        './views/forms/addAnswerForm.php'
                    ], 
                    'question' => $question, 
                    'answers' => $answers
                    ]);
            }
        } else {
            $question = $this->model->show($id);
            $answers = $this->model->show_answers($id);
            $this->view->render([
                'files' => 
                [
                    './views/components/question/detail.php', 
                    './views/forms/addAnswerForm.php'
                ], 
                'question' => $question, 
                'answers' => $answers
                ]);
        }  
    }

    function like($id) {
        $question_id = $this->model->like($id);
        $_SESSION['message'] = "Thanks for your vote";
        header('Location:'.getenv('website_path').'question/show/'.$question_id);
        return true;
    }

    function unlike($id) {
        $question_id = $this->model->unlike($id);
        $_SESSION['message'] = "Thanks for your vote";
        header('Location:'.getenv('website_path').'question/show/'.$question_id);
        return true;
    }

    function search() {

        if(isset($_POST['pattern'])) {
            $pattern = $_POST['pattern'];

            $questions = $this->model->search($pattern);

            if($questions->rowCount() < 1) {
                $_SESSION['message'] = "THERE IS NO QUESTION LIKE: ".$pattern;
            }

            $this->view->render([
                'files' => 
                [
                    './views/components/question/list.php',
                    './views/components/question/pagination.php'
                ], 
                'questions' => $questions
                ]);
        }
    }
}