<?php
/**
 * Created by PhpStorm.
 * User: Mehmet
 * Date: 28.11.2018
 * Time: 15:38
 */

?>

<!-- Title page -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
    <h2 class="ltext-105 cl0 txt-center">
         <?=$m_lang[$lang][4]?>
    </h2>
</section>


<!-- Content page -->
<section class="bg0 p-t-104 p-b-116">
    <div class="container">
        <div class="flex-w flex-tr">
            <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
                <form>
                    <h4 class="mtext-105 cl2 txt-center p-b-30">
                       <?=$m_lang[$lang][37]?>
                    </h4>

                    <div class="bor8 m-b-20 how-pos4-parent">
                        <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="email" placeholder="Email adresiniz">
                        <img class="how-pos4 pointer-none" src="images/icons/icon-email.png" alt="ICON">
                    </div>

                    <div class="bor8 m-b-30">
                        <textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" name="msg" placeholder="Size nasıl yardımcı olabiliriz?"></textarea>
                    </div>

                    <button class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                       <?=$m_lang[$lang][38]?>
                    </button>
                </form>
            </div>

            <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
                <div class="flex-w w-full p-b-42">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-map-marker"></span>
						</span>

                    <div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
									<?=$m_lang[$lang][39]?>
							</span>

                        <p class="stext-115 cl6 size-213 p-t-18">
                            Odabaşı Mah. Atatürk Blv No:11 ANTAKYA/HATAY 
                        </p>
                    </div>
                </div>

                <div class="flex-w w-full p-b-42">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-phone-handset"></span>
						</span>

                    <div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
									<?=$m_lang[$lang][40]?>
							</span>

                        <p class="stext-115 cl1 size-213 p-t-18">
                           0541 265 13 59
                        </p>
                    </div>
                </div>

                <div class="flex-w w-full">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-envelope"></span>
						</span>

                    <div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
									<?=$m_lang[$lang][41]?>
							</span>

                        <p class="stext-115 cl1 size-213 p-t-18">
                           info@optimumilac.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!--  Map -->
<div class="map">
    <div class="size-303" id="google_map" data-map-x="36.204214" data-map-y="36.160108"  data-scrollwhell="0" data-draggable="1" data-zoom="18"></div>
</div>

<!--===============================================================================================-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>
<script src="js/map-custom.js"></script>
<!--===============================================================================================-->



