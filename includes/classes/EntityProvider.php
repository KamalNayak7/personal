<?php
class EntityProvider {

    public static function getEntities($con, $categoryId, $limit) {

        $sql = "SELECT * FROM entities ";

        if($categoryId != null) {//obviously  they wanta perticular category and all entities for that category
            $sql .= "WHERE categoryId=:categoryId ";
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $con->prepare($sql);

        if($categoryId != null) {
            $query->bindValue(":categoryId", $categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);//PDO::PARAM_INT -telling limit is int
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {//row contains entites  data
            $result[] = new Entity($con, $row);//[] put item is next avail space in array
        }

        return $result;
    }

    public static function getTVShowEntities($con, $categoryId, $limit) { // to get TV shows

        $sql = "SELECT DISTINCT(entities.id) FROM `entities`
                INNER JOIN videos
                ON entities.id = videos.entityId
                WHERE videos.isMovie = 0 ";//add space to append $sql below or the RAND() part

        if($categoryId != null) {
            $sql .= "AND categoryId=:categoryId ";
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $con->prepare($sql);

        if($categoryId != null) {
            $query->bindValue(":categoryId", $categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Entity($con, $row["id"]);//just pass the id column to entity object
        }

        return $result;
    }

    public static function getMoviesEntities($con, $categoryId, $limit) {//to get movies

        $sql = "SELECT DISTINCT(entities.id) FROM `entities`
                INNER JOIN videos
                ON entities.id = videos.entityId
                WHERE videos.isMovie = 1 ";//add space to append $sql below or the RAND() part

        if($categoryId != null) {
            $sql .= "AND categoryId=:categoryId ";
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $con->prepare($sql);

        if($categoryId != null) {
            $query->bindValue(":categoryId", $categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Entity($con, $row["id"]);//just pass the id column to entity object
        }

        return $result;
    }

    public static function getSearchEntities($con, $term) {

        $sql = "SELECT * FROM entities WHERE name LIKE CONCAT('%', :term, '%') LIMIT 30";

        $query = $con->prepare($sql);

        $query->bindValue(":term", $term);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Entity($con, $row);
        }

        return $result;
    }

}
?>