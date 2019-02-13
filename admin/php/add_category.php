<?php
/**
 * Created by PhpStorm.
 * User: mehmet
 * Date: 30.11.2018
 * Time: 21:59
 */

 if($user->getAllCategory())
    $category = $user->getAllCategory();


?>
<style>
.mt-70 {
  margin-top: 70px !important;
}

</style>
  <div class="row">
  <div class="col-md-8 mt-70">
        <form name="item" method="post" action="index.php" enctype = "multipart/form-data">
         
               
                <div class="col-sm-10">
                        <div class="alert alert-primary " role="alert">
                                Kategori Ekle
                              </div>
                   <input type="text" class="form-control boxed"  name="ad_category" >
                </div>
                
               
                
        <hr>
        <input type="hidden" name="admin_category" value="add">
             <input type="submit" class="btn btn-info col-sm-10" value="Ekle">
            
       
   </form>
   </div>


    <div class="col-md-4 mt-70">
    <table class="table table-dark table-striped table-hover" >
<thead class="dark">

    <tr>
    <th scope="col">#</th>   
    <th scope="col">Kategoriler</th>
    <th scope="col">Kategori Düzenleme</th>    
    </tr>
</thead>

<tbody> 
<?php $i = 1; foreach ($category as $kategori) { 
    //0 id 1 isim
    //döngü kaç kere dönüyorsa d
    //hayır zaten bu bütün kategorileri geziyor tamem bende diyomki 4 kere dönüyrosa 1den 4 e kadar sayı atsın hmm tmm
    //Silme Panelini sağa Eklemeyi Sola Al nasıl yani
    //Siyah panel soldayken şey gibi görünüyor alt kategorisi gibi yönetim panelinin ,Kategori ekleyimi diyorsun orayımu d anlamadım
    //bu paneli yer  mi değişyim aynen Oyş :D silmeyide ayarlarsak miss
    //aynen ama dene de yara ye yok kardeş almiyim ya php 
    // sevmiyorum asjdjsadjasjd
    //asdjkhaksjd neyse sana iyi haberler vermek isterdim ama .. ne için
    //raporlama ile ilgili
    //crystal reportu mu entegre ettin
    //Yoh, ama tasarımsal olarak kaymalar yaşanıyor ama fixledim gibi iyi güzel yazamadım amk kategori silmede tamam nerdeyse raporda tamamsa gg ya
    //Raporun bi sıkıntılı tarafı var pixel bazında işlem yapyor her bir harfi 1px düşünüyorsun ama öyle olmuyor.
    //yarım saattir bu kaymayı fixlemeye çalışıyorum
    //ve işin kötü tarafı bu çoğu frameworkte varmışş ve sorun px bazında yazım yapılması gözle görünür mü yani cok mu  sıkıntı ?
    //çok uzun girdilerde büyük sıkıntı olur gözle görünüyor
   // gel pc ye tmm at bakim bunlar kaslın hatıra sajdasjdasjdjsa
    ?>
<tr>
        <th scope="row"><?=$i?></th>
        
        <td> <?=$kategori[1]?></td>

    <form method="post" action="index.php"><td><input type="hidden" name="cat_id" value="<?=$kategori[0]?>"/><input type="submit" name="admin_delete_cat" class="btn btn-danger btn-xs" value="Sil"/> <button type="button" class="btn btn-warning">Düzenle</button> </td></form>
        
    

</tr>
<?php  $i++; } $i = 0;  ?>
</tbody> 


    </table>
</div>

</div>
   
          