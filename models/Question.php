<?php 
class Question extends Model {
    function __contruct() {
        parent::__contruct();
    }

    function countQuestions() {
       $sql = "SELECT * FROM question";
       $stmt = $this->db->prepare($sql);

       if($stmt->execute()) {
           return $stmt->rowCount();
       }
    }

    function create($request) {
        $name = $request['name'];
        $title = $request['title'];
        $content = $request['content'];
        $ip = $_SERVER['REMOTE_ADDR'];

        $sql = 'INSERT INTO question'.
            ' VALUES (NULL, :name, :ip, :title, :content,'.
            ' NULL, NULL)';

        if($stmt = $this->db->prepare($sql)) {
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':ip', $ip);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);

            if($stmt->execute()) {
                return true;
            }
        }

    }

    function create_answer($request, $question_id) {
        $name = $request['name'];
        $content = $request['content'];
        $ip = $_SERVER['REMOTE_ADDR'];

        $sql = 'INSERT INTO answer'.
            ' VALUES (NULL, :question_id, :name, :ip, :content,'.
            ' 0, 0, NULL)';

        if($stmt = $this->db->prepare($sql)) {
            $stmt->bindParam(':question_id', $question_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':ip', $ip);
            $stmt->bindParam(':content', $content);

            if($stmt->execute()) {
                $sql_update_question = "UPDATE question SET modified = NOW() WHERE id = :id";
                if($stmt_u = $this->db->prepare($sql_update_question)) {
                    $stmt_u->bindParam(':id', $question_id);
                    
                    if($stmt_u->execute()) {
                        return true;
                    }
                }
            } else {
                echo 'tutaj';
            }
        } 

    }

    function read($from, $questionsPerPage) {
        $sql = "SELECT * FROM question ORDER BY modified DESC LIMIT 3 OFFSET $from";
        $stmt = $this->db->prepare($sql);

        if($stmt->execute()) {
            return $stmt;
        }
    }

    function show($id) {
        $sql = "SELECT * FROM question WHERE id = :id";
        if($stmt = $this->db->prepare($sql)){
            $stmt->bindParam(':id', $id);

            if($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }
    }

    function show_answers($question_id) {
        $sql = "SELECT * FROM answer WHERE question_id = :question_id";
        if($stmt = $this->db->prepare($sql)){
            $stmt->bindParam(':question_id', $question_id);

            if($stmt->execute()) {
                return $stmt;
            }
        }
    }

    function like($id) {
        $sql = "UPDATE answer SET likes = likes + 1 WHERE id = :id";

        if($stmt = $this->db->prepare($sql)) {
            $stmt->bindParam(':id', $id);

            if($stmt->execute()) {
                $sql_question_id = "SELECT question_id FROM answer WHERE id = :id";

                if($stmt_q = $this->db->prepare($sql_question_id)) {
                    $stmt_q->bindParam(':id', $id);

                    if($stmt_q->execute()) {
                        $result = $stmt_q->fetch(PDO::FETCH_ASSOC);
                        return $result['question_id'];
                    }
                }
            }
        } 
    }

    function unlike($id) {
        $sql = "UPDATE answer SET unlikes = unlikes + 1 WHERE id = :id";

        if($stmt = $this->db->prepare($sql)) {
            $stmt->bindParam(':id', $id);

            if($stmt->execute()) {
                $sql_question_id = "SELECT question_id FROM answer WHERE id = :id";

                if($stmt_q = $this->db->prepare($sql_question_id)) {
                    $stmt_q->bindParam(':id', $id);

                    if($stmt_q->execute()) {
                        $result = $stmt_q->fetch(PDO::FETCH_ASSOC);
                        return $result['question_id'];
                    }
                }
            }
        } 
    }
    

    function search($pattern) {
        $sql = "SELECT * FROM question WHERE title LIKE :pattern";
        $pattern = '%'.$pattern.'%';

        if($stmt = $this->db->prepare($sql)){
            $stmt->bindParam(':pattern', $pattern);

            if($stmt->execute()) {
                return $stmt;
            }
        }
        
    }
}