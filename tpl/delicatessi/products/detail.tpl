<div class="single">
<!-- start span1_of_1 -->
<div class="left_content">
    <div class="span1_of_1">
        <!-- start product_slider -->
            <div class="product-thumbs">
                <ul>
                    <li>
                        <a class="cs-fancybox-thumbs" data-fancybox-group="thumb"  href="#"  title="" alt="">
                            <img src="{$product['image']}"  title="" alt="" /></a>
                    </li>
                    <li>
                        <a class="cs-fancybox-thumbs" data-fancybox-group="thumb"  href="#"  title="" alt="">
                            <img src="{$product['image']}"  title="" alt="" /></a>
                    </li>
                </ul>
            </div>
        <div class="product-image">
            <img src="{$product['image']}" alt="{$product['product_name']}" title="{$product['product_name']}" />
        </div>
        <!-- end product_slider -->
    </div>
    <!-- start span1_of_1 -->
    <div class="span1_of_1_des">
        <div class="desc1">
            <h3>{$product['product_name']}</h3>
            <h5>{String::convertTextFormat($product['price'], 'currency')}</h5>
            <div class="available">
                <div class="btn_form">
                    <form>
                        <input type="submit" value="Eu Quero" title="" />
                    </form>
                </div>
                <span><a href="{$smarty.const.BASEDIR}products/addfavourite?id={$product['id']}">Adicionar aos favoritos</a></span>
                <p>{$product['description']}</p>
            </div>
            <div class="share-desc">
                <div class="share">
                    <h4>Compartilhar:</h4>
                    <ul class="share_nav">
                        <li><a href="{$smarty.const.BASEDIR}product/share?social=facebook"><img src="{$smarty.const.T_IMGURL}/facebook.png" title="facebook"></a></li>
                        <li><a href="{$smarty.const.BASEDIR}product/share?social=twitter"><img src="{$smarty.const.T_IMGURL}/twitter.png" title="Twiiter"></a></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <!-- start left content_bottom -->
    <div class="left_content_btm">
        <!-- start tabs -->
        <section class="tabs">
            <input id="tab-1" type="radio" name="radio-set" class="tab-selector-1" checked="checked">
            <label for="tab-1" class="tab-label-1">Características</label>

            <input id="tab-2" type="radio" name="radio-set" class="tab-selector-2">
            <label for="tab-2" class="tab-label-2">Garantia</label>

            <div class="clear-shadow"></div>

            <div class="content">
                <div class="content-1">
                    <p class="para top"><span>LOREM IPSUM</span> There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined </p>
                    <ul>
                        <li>Research</li>
                        <li>Design and Development</li>
                        <li>Porting and Optimization</li>
                        <li>System integration</li>
                        <li>Verification, Validation and Testing</li>
                        <li>Maintenance and Support</li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="content-2">
                    <p class="para"><span>WELCOME </span> Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections </p>
                    <ul class="qua_nav">
                        <li>Multimedia Systems</li>
                        <li>Digital media adapters</li>
                        <li>Set top boxes for HDTV and IPTV Player applications on various Operating Systems and Hardware Platforms</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- end tabs -->
    </div>
    <!-- end left content_bottom -->
</div>
<!-- start left_sidebar -->
{$gadget}
<div class="clear"></div>
</div>