<div class="single">
<!-- start span1_of_1 -->
<div class="left_content">
    <div class="span1_of_1">
        <!-- start product_slider -->
            <div class="product-thumbs">
                <ul>
                    <li>
                        <a data-action="enlarge" class="cs-fancybox-thumbs" data-fancybox-group="thumb"  href="#"  title="" alt="">
                            <img src="{$product['image']}"  title="" alt="" /></a>
                    </li>
                    {foreach from=$images item="image"}
                        <li>
                            <a data-action="enlarge" class="cs-fancybox-thumbs" data-fancybox-group="thumb"  href="#"  title="" alt="">
                                <img src="{$image['image']}"  title="" alt="" /></a>
                        </li>
                    {/foreach}
                </ul>
            </div>
        <div class="product-image">
            <img id="product-image-large" src="{$product['image']}" alt="{$product['product_name']}" title="{$product['product_name']}" />
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
                    <form method="get" action="{$smarty.const.BASEDIR}products/addtocart">
                        <input type="submit" value="Eu Quero" title="" />
                        <input type="hidden" name="product_id" value="{$product['id']}">
                    </form>
                </div>
                <span id="addfav">
                    {if ($isfav)}
                        <a href="{$smarty.const.BASEDIR}client/favs">Este é um de seus favoritos!</a>
                    {else}
                        <a href="{$smarty.const.BASEDIR}products/addfavourite?id={$product['id']}">Adicionar aos favoritos</a>
                    {/if}
                </span>
                <p>{$product['description']}</p>
            </div>
            <div class="share-desc">
                <div class="share">
                    <h4>Compartilhar:</h4>
                    <ul class="share_nav">
                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={$smarty.const.MAINURL}/products/{$product['id']}"><img src="{$smarty.const.T_IMGURL}/facebook.png" title="facebook"></a></li>
                        <li><a href="https://twitter.com/home?status={$smarty.const.MAINURL}/products/{$product['id']}"><img src="{$smarty.const.T_IMGURL}/twitter.png" title="Twiiter"></a></li>
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
                    <p class="para top"><span>{$product['product_name']}</span> {$product['description']}</p>
                    <div class="clear"></div>
                </div>
                <div class="content-2">
                    <p class="para">
                    Todas as Semi-jóias são banhadas a ouro ou prata de ótima qualidade. <br>
                        Oferecemos 1 ano de garantia na cor e pedrarias para todas as Semi-jóias
                    </p>
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