
<?php


 /**
  * Curso Data Access Object (DAO).
  * This class contains all database handling that is needed to 
  * permanently store and retrieve Curso object instances. 
  */

 /**
  * This sourcecode has been generated by FREE DaoGen generator version 2.4.1.
  * The usage of generated code is restricted to OpenSource software projects
  * only. DaoGen is available in http://titaniclinux.net/daogen/
  * It has been programmed by Tuomo Lukka, Tuomo.Lukka@iki.fi
  *
  * DaoGen license: The following DaoGen generated source code is licensed
  * under the terms of GNU GPL license. The full text for license is available
  * in GNU project's pages: http://www.gnu.org/copyleft/gpl.html
  *
  * If you wish to use the DaoGen generator to produce code for closed-source
  * commercial applications, you must pay the lisence fee. The price is
  * 5 USD or 5 Eur for each database table, you are generating code for.
  * (That includes unlimited amount of iterations with all supported languages
  * for each database table you are paying for.) Send mail to
  * "Tuomo.Lukka@iki.fi" for more information. Thank you!
  */



class CursoDao {


    /**
     * createValueObject-method. This method is used when the Dao class needs
     * to create new value object instance. The reason why this method exists
     * is that sometimes the programmer may want to extend also the valueObject
     * and then this method can be overrided to return extended valueObject.
     * NOTE: If you extend the valueObject class, make sure to override the
     * clone() method in it!
     */
    function createValueObject() {
          return new Curso();
    }


    /**
     * getObject-method. This will create and load valueObject contents from database 
     * using given Primary-Key as identifier. This method is just a convenience method 
     * for the real load-method which accepts the valueObject as a parameter. Returned
     * valueObject will be created using the createValueObject() method.
     */
    function getObject(&$conn, $cod_curso) {

          $valueObject = $this->createValueObject();
          $valueObject->setCod_curso($cod_curso);
          $this->load(&$conn, &$valueObject);
          return $valueObject;
    }


    /**
     * load-method. This will load valueObject contents from database using
     * Primary-Key as identifier. Upper layer should use this so that valueObject
     * instance is created and only primary-key should be specified. Then call
     * this method to complete other persistent information. This method will
     * overwrite all other fields except primary-key and possible runtime variables.
     * If load can not find matching row, NotFoundException will be thrown.
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance to be loaded.
     *                     Primary-key field must be set for this to work properly.
     */
    function load(&$conn, &$valueObject) {

          if (!$valueObject->getCod_curso()) {
               //print "Can not select without Primary-Key!";
               return false;
          }

          $sql = "SELECT * FROM curso WHERE (cod_curso = ".$valueObject->getCod_curso().") "; 

          if ($this->singleQuery(&$conn, $sql, &$valueObject))
               return true;
          else
               return false;
    }


    /**
     * LoadAll-method. This will read all contents from database table and
     * build an Vector containing valueObjects. Please note, that this method
     * will consume huge amounts of resources if table has lot's of rows. 
     * This should only be used when target tables have only small amounts
     * of data.
     *
     * @param conn         This method requires working database connection.
     */
    function loadAll(&$conn) {


          $sql = "SELECT * FROM curso ORDER BY cod_curso ASC ";

          $searchResults = $this->listQuery(&$conn, $sql);

          return $searchResults;
    }



    /**
     * create-method. This will create new row in database according to supplied
     * valueObject contents. Make sure that values for all NOT NULL columns are
     * correctly specified. Also, if this table does not use automatic surrogate-keys
     * the primary-key must be specified. After INSERT command this method will 
     * read the generated primary-key back to valueObject if automatic surrogate-keys
     * were used. 
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance to be created.
     *                     If automatic surrogate-keys are not used the Primary-key 
     *                     field must be set for this to work properly.
     */
    function create(&$conn, &$valueObject) {

          $sql = "INSERT INTO curso ( cod_curso, nome_curso, inscricao_inicio, ";
          $sql = $sql."inscricao_fim, curso_inicio, curso_fim, ";
          $sql = $sql."informacoes, publico_alvo, tipo_inscricao, ";
          $sql = $sql."num_alunos, cod_coordenador, acesso_visitante, ";
          $sql = $sql."cod_pasta, timestamp, cod_lingua) VALUES (".$valueObject->getCod_curso().", ";
          $sql = $sql."'".$valueObject->getNome_curso()."', ";
          $sql = $sql."".$valueObject->getInscricao_inicio().", ";
          $sql = $sql."".$valueObject->getInscricao_fim().", ";
          $sql = $sql."".$valueObject->getCurso_inicio().", ";
          $sql = $sql."".$valueObject->getCurso_fim().", ";
          $sql = $sql."'".$valueObject->getInformacoes()."', ";
          $sql = $sql."'".$valueObject->getPublico_alvo()."', ";
          $sql = $sql."'".$valueObject->getTipo_inscricao()."', ";
          $sql = $sql."".$valueObject->getNum_alunos().", ";
          $sql = $sql."".$valueObject->getCod_coordenador().", ";
          $sql = $sql."'".$valueObject->getAcesso_visitante()."', ";
          $sql = $sql."".$valueObject->getCod_pasta().", ";
          $sql = $sql."".$valueObject->getTimestamp().", ";
          $sql = $sql."".$valueObject->getCod_lingua().") ";
          $result = $this->databaseUpdate(&$conn, $sql);


          return true;
    }


    /**
     * save-method. This method will save the current state of valueObject to database.
     * Save can not be used to create new instances in database, so upper layer must
     * make sure that the primary-key is correctly specified. Primary-key will indicate
     * which instance is going to be updated in database. If save can not find matching 
     * row, NotFoundException will be thrown.
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance to be saved.
     *                     Primary-key field must be set for this to work properly.
     */
    function save(&$conn, &$valueObject) {

          $sql = "UPDATE curso SET nome_curso = '".$valueObject->getNome_curso()."', ";
          $sql = $sql."inscricao_inicio = ".$valueObject->getInscricao_inicio().", ";
          $sql = $sql."inscricao_fim = ".$valueObject->getInscricao_fim().", ";
          $sql = $sql."curso_inicio = ".$valueObject->getCurso_inicio().", ";
          $sql = $sql."curso_fim = ".$valueObject->getCurso_fim().", ";
          $sql = $sql."informacoes = '".$valueObject->getInformacoes()."', ";
          $sql = $sql."publico_alvo = '".$valueObject->getPublico_alvo()."', ";
          $sql = $sql."tipo_inscricao = '".$valueObject->getTipo_inscricao()."', ";
          $sql = $sql."num_alunos = ".$valueObject->getNum_alunos().", ";
          $sql = $sql."cod_coordenador = ".$valueObject->getCod_coordenador().", ";
          $sql = $sql."acesso_visitante = '".$valueObject->getAcesso_visitante()."', ";
          $sql = $sql."cod_pasta = ".$valueObject->getCod_pasta().", ";
          $sql = $sql."timestamp = ".$valueObject->getTimestamp().", ";
          $sql = $sql."cod_lingua = ".$valueObject->getCod_lingua()."";
          $sql = $sql." WHERE (cod_curso = ".$valueObject->getCod_curso().") ";
          $result = $this->databaseUpdate(&$conn, $sql);

          if ($result != 1) {
               //print "PrimaryKey Error when updating DB!";
               return false;
          }

          return true;
    }


    /**
     * delete-method. This method will remove the information from database as identified by
     * by primary-key in supplied valueObject. Once valueObject has been deleted it can not 
     * be restored by calling save. Restoring can only be done using create method but if 
     * database is using automatic surrogate-keys, the resulting object will have different 
     * primary-key than what it was in the deleted object. If delete can not find matching row,
     * NotFoundException will be thrown.
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance to be deleted.
     *                     Primary-key field must be set for this to work properly.
     */
    function delete(&$conn, &$valueObject) {


          if (!$valueObject->getCod_curso()) {
               //print "Can not delete without Primary-Key!";
               return false;
          }

          $sql = "DELETE FROM curso WHERE (cod_curso = ".$valueObject->getCod_curso().") ";
          $result = $this->databaseUpdate(&$conn, $sql);

          if ($result != 1) {
               //print "PrimaryKey Error when updating DB!";
               return false;
          }
          return true;
    }


    /**
     * deleteAll-method. This method will remove all information from the table that matches
     * this Dao and ValueObject couple. This should be the most efficient way to clear table.
     * Once deleteAll has been called, no valueObject that has been created before can be 
     * restored by calling save. Restoring can only be done using create method but if database 
     * is using automatic surrogate-keys, the resulting object will have different primary-key 
     * than what it was in the deleted object. (Note, the implementation of this method should
     * be different with different DB backends.)
     *
     * @param conn         This method requires working database connection.
     */
    function deleteAll(&$conn) {

          $sql = "DELETE FROM curso";
          $result = $this->databaseUpdate(&$conn, $sql);

          return true;
    }


    /**
     * coutAll-method. This method will return the number of all rows from table that matches
     * this Dao. The implementation will simply execute "select count(primarykey) from table".
     * If table is empty, the return value is 0. This method should be used before calling
     * loadAll, to make sure table has not too many rows.
     *
     * @param conn         This method requires working database connection.
     */
    function countAll(&$conn) {

          $sql = "SELECT count(*) FROM curso";
          $allRows = 0;

          $result = $conn->execute($sql);

          if ($row = $conn->nextRow($result))
                $allRows = $row[0];

          return $allRows;
    }


    /** 
     * searchMatching-Method. This method provides searching capability to 
     * get matching valueObjects from database. It works by searching all 
     * objects that match permanent instance variables of given object.
     * Upper layer should use this by setting some parameters in valueObject
     * and then  call searchMatching. The result will be 0-N objects in vector, 
     * all matching those criteria you specified. Those instance-variables that
     * have NULL values are excluded in search-criteria.
     *
     * @param conn         This method requires working database connection.
     * @param valueObject  This parameter contains the class instance where search will be based.
     *                     Primary-key field should not be set.
     */
    function searchMatching(&$conn, &$valueObject) {

          $first = true;
          $sql = "SELECT * FROM curso WHERE 1=1 ";

          if ($valueObject->getCod_curso() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND cod_curso = ".$valueObject->getCod_curso()." ";
          }

          if ($valueObject->getNome_curso() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND nome_curso LIKE '".$valueObject->getNome_curso()."%' ";
          }

          if ($valueObject->getInscricao_inicio() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND inscricao_inicio = ".$valueObject->getInscricao_inicio()." ";
          }

          if ($valueObject->getInscricao_fim() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND inscricao_fim = ".$valueObject->getInscricao_fim()." ";
          }

          if ($valueObject->getCurso_inicio() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND curso_inicio = ".$valueObject->getCurso_inicio()." ";
          }

          if ($valueObject->getCurso_fim() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND curso_fim = ".$valueObject->getCurso_fim()." ";
          }

          if ($valueObject->getInformacoes() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND informacoes LIKE '".$valueObject->getInformacoes()."%' ";
          }

          if ($valueObject->getPublico_alvo() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND publico_alvo LIKE '".$valueObject->getPublico_alvo()."%' ";
          }

          if ($valueObject->getTipo_inscricao() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND tipo_inscricao LIKE '".$valueObject->getTipo_inscricao()."%' ";
          }

          if ($valueObject->getNum_alunos() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND num_alunos = ".$valueObject->getNum_alunos()." ";
          }

          if ($valueObject->getCod_coordenador() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND cod_coordenador = ".$valueObject->getCod_coordenador()." ";
          }

          if ($valueObject->getAcesso_visitante() != "") {
              if ($first) { $first = false; }
              $sql = $sql."AND acesso_visitante LIKE '".$valueObject->getAcesso_visitante()."%' ";
          }

          if ($valueObject->getCod_pasta() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND cod_pasta = ".$valueObject->getCod_pasta()." ";
          }

          if ($valueObject->getTimestamp() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND timestamp = ".$valueObject->getTimestamp()." ";
          }

          if ($valueObject->getCod_lingua() != 0) {
              if ($first) { $first = false; }
              $sql = $sql."AND cod_lingua = ".$valueObject->getCod_lingua()." ";
          }


          $sql = $sql."ORDER BY cod_curso ASC ";

          // Prevent accidential full table results.
          // Use loadAll if all rows must be returned.
          if ($first)
               return array();

          $searchResults = $this->listQuery(&$conn, $sql);

          return $searchResults;
    }

    /**
     * databaseQuery-method. This method is a helper method for internal use. It will execute
     * all database queries that will return only one row. The resultset will be converted
     * to valueObject. If no rows were found, NotFoundException will be thrown.
     *
     * @param conn         This method requires working database connection.
     * @param stmt         This parameter contains the SQL statement to be excuted.
     * @param valueObject  Class-instance where resulting data will be stored.
     */
    function singleQuery(&$conn, &$sql, &$valueObject) {

          $result = $conn->execute($sql);

          if ($row = $conn->nextRow($result)) {

                   $valueObject->setCod_curso($row[0]); 
                   $valueObject->setNome_curso($row[1]); 
                   $valueObject->setInscricao_inicio($row[2]); 
                   $valueObject->setInscricao_fim($row[3]); 
                   $valueObject->setCurso_inicio($row[4]); 
                   $valueObject->setCurso_fim($row[5]); 
                   $valueObject->setInformacoes($row[6]); 
                   $valueObject->setPublico_alvo($row[7]); 
                   $valueObject->setTipo_inscricao($row[8]); 
                   $valueObject->setNum_alunos($row[9]); 
                   $valueObject->setCod_coordenador($row[10]); 
                   $valueObject->setAcesso_visitante($row[11]); 
                   $valueObject->setCod_pasta($row[12]); 
                   $valueObject->setTimestamp($row[13]); 
                   $valueObject->setCod_lingua($row[14]); 
          } else {
               //print " Object Not Found!";
               return false;
          }
          return true;
    }


    /**
     * databaseQuery-method. This method is a helper method for internal use. It will execute
     * all database queries that will return multiple rows. The resultset will be converted
     * to the List of valueObjects. If no rows were found, an empty List will be returned.
     *
     * @param conn         This method requires working database connection.
     * @param stmt         This parameter contains the SQL statement to be excuted.
     */
    function listQuery(&$conn, &$sql) {

          $searchResults = array();
          $result = $conn->execute($sql);

          while ($row = $conn->nextRow($result)) {
               $temp = $this->createValueObject();

               $temp->setCod_curso($row[0]); 
               $temp->setNome_curso($row[1]); 
               $temp->setInscricao_inicio($row[2]); 
               $temp->setInscricao_fim($row[3]); 
               $temp->setCurso_inicio($row[4]); 
               $temp->setCurso_fim($row[5]); 
               $temp->setInformacoes($row[6]); 
               $temp->setPublico_alvo($row[7]); 
               $temp->setTipo_inscricao($row[8]); 
               $temp->setNum_alunos($row[9]); 
               $temp->setCod_coordenador($row[10]); 
               $temp->setAcesso_visitante($row[11]); 
               $temp->setCod_pasta($row[12]); 
               $temp->setTimestamp($row[13]); 
               $temp->setCod_lingua($row[14]); 
               array_push($searchResults, $temp);
          }

          return $searchResults;
    }
}

?>