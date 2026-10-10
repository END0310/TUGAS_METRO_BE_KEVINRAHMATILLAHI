<?php
    $Total_Belanja=1000000;
    $diskon=0;
    function hitung_diskon($Total_Belanja){
        if($Total_Belanja <50000){
            $diskon=0;
            $Total_Belanja_setelah_diskon=$Total_Belanja-$Total_Belanja*$diskon;
            echo"Total Belanja Sebelum Diskon=$Total_Belanja\n";
            echo"Diskon=$diskon\n";
            echo"Total Belanja Setelah Diskon=$Total_Belanja_setelah_diskon";
        } elseif ($Total_Belanja >=50000 && $Total_Belanja <= 200000 ){
            $diskon=0.1;
            $Total_Belanja_setelah_diskon=$Total_Belanja-$Total_Belanja*$diskon;
            echo"Total Belanja Sebelum Diskon=$Total_Belanja\n";
            echo"Diskon=$diskon\n";
            echo"Total Belanja Setelah Diskon=$Total_Belanja_setelah_diskon";
        }else{
            $diskon=0.2;
            $Total_Belanja_setelah_diskon=$Total_Belanja-$Total_Belanja*$diskon;
            echo"Total Belanja Sebelum Diskon=$Total_Belanja\n";
            echo"Diskon=$diskon\n";
            echo"Total Belanja Setelah Diskon=$Total_Belanja_setelah_diskon";
         }
        }
    echo hitung_diskon($Total_Belanja);
    ?>