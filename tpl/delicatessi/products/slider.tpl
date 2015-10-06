<div class="slider">
    <!---start-image-slider---->
    <div class="image-slider">
        <div class="wrapper">
            <div id="ei-slider" class="ei-slider">
                <ul class="ei-slider-large">
                    {foreach from=$featured item="row"}
                        <li>
                            <img src="{if ($row['cover_image'] != '')}{$row['cover_image']}{else}{$smarty.const.T_IMGURL}/slider-default.jpg{/if}" alt="image06"/>
                            <div class="ei-title">
                                <div class="slider-image">
                                    <img src="{$row['image']}" alt="{$row['product_name']}"/>
                                </div>
                                <h3 class="btn">{String::convertTextFormat($row['price'], 'currency')}</h3>
                                <h2>{$row['product_name']}</h2>
                                <h3 class="active">{$row['description']}
                                </h3>
                                <h3>
                                    <a class="ei_icons" href="{$smarty.const.BASEDIR}products/{$row['id']}"><img src="{$smarty.const.T_IMGURL}/icon_1.png" alt=""></a>
                                    <a class="ei_icons" href="{$smarty.const.BASEDIR}products/addfavourite?id={$row['id']}"><img src="{$smarty.const.T_IMGURL}/icon_2.png" alt=""></a>
                                    <!--<a class="ei_icons" href="#"><img src="{$smarty.const.T_IMGURL}/icon_3.png" alt=""></a>-->
                                    <a class="ei_icons" href="{$smarty.const.BASEDIR}products/addtocart?product_id={$row['id']}"><img src="{$smarty.const.T_IMGURL}/icon_4.png" alt=""></a>
                                </h3>
                            </div>
                        </li>
                    {/foreach}
                </ul><!-- ei-slider-large -->
                <ul class="ei-slider-thumbs">
                    {foreach from=$featured key="key" item="row"}
                        {if ($key === 0)}
                            <li class="ei-slider-element">Current</li>
                            <li>
                                <a href="#">
                                    <span class="active"></span>
                                </a>
                                <img src="{$row['image']}" alt="{$row['product_name']}" />
                            </li>
                        {else}
                            <li><a href="#"><span></span></a><img src="{$row['image']}" alt="{$row['product_name']}" /></li>
                        {/if}
                    {/foreach}
                </ul><!-- ei-slider-thumbs -->
            </div><!-- ei-slider -->
        </div><!-- wrapper -->
    </div>
    <!---End-image-slider---->
</div>