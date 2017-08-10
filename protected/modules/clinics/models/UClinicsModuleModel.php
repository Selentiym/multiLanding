<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.02.2017
 * Time: 12:16
 */
//AActiveRecord is needed to implement identity map pattern
abstract class UClinicsModuleModel extends AActiveRecord {
    private static $_connectionTypes = [
        'clinic' => 'dbConfig',
        'article' => 'dbArticles'
    ];
    public function readData($data){
        return true;
    }
    public function checkCreateAccess(){
        return Yii::app() -> controller -> isSuperAdmin();
    }
    public function checkUpdateAccess(){
        return Yii::app() -> controller -> isSuperAdmin();
    }
    public function checkDeleteAccess(){
        return Yii::app() -> controller -> isSuperAdmin();
    }
    public function explainErrors(){
        var_dump($this -> getErrors());
    }

    /**
     * @return string
     */
    public function getModuleClassName() {
        return 'ClinicsModule';
    }

    protected function getDbType(){
        return 'clinic';
    }

    public function getDbConnection(){
        $i = $this -> getModule();
        return $i -> getDbConnection(self::$_connectionTypes[$this->getDbType()]);
    }
    public static function groupBy($objects, $attr){
        $rez = [];
        foreach ($objects as $object) {
            try {
                if (is_callable($attr)) {
                    $evaluated = call_user_func($attr, $object);
                } else {
                    $evaluated = $object -> $attr;
                }
                $rez[$evaluated][] = $object;
            } catch (Exception $e) {}
        }
        return $rez;
    }
}