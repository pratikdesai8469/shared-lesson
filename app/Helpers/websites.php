<?php
    use App\Models\MetaSeo;
    
    function metaData() {
        $metaData = MetaSeo::first();
        return $metaData;
    }
?>