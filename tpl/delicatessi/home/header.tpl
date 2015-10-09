<div class="top_bg">
    <div class="wrap">
        <div class="header">
            <div>
                <div class="web_search margin-menu-top">
                    <form method="get" action="{$smarty.const.BASEDIR}products" changeurl>
                        <input type="text" name="search" placeholder="O que você procura?" value="">
                        <input type="submit" value=" " />
                    </form>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <div class="home-top">
            <div class="logo">
                <a href="{$smarty.const.BASEDIR}home" changeurl><img src="{$smarty.const.T_IMGURL}/logo.png" alt=""/></a>
            </div>
            <div class="log_reg margin-menu-top">
                <ul id="header-links">
                    <li><a href="{$smarty.const.BASEDIR}client" changeurl>Minha Conta</a> </li>
                    <span class="log"> | </span>
                    <li><a href="{$smarty.const.BASEDIR}client/register" changeurl>Criar Conta</a> </li>
                    <span class="log"> | </span>
                    <li><a href="{$smarty.const.BASEDIR}contact" changeurl>Fale Conosco</a> </li>
                </ul>
                <img src="{$smarty.const.T_IMGURL}/no_avatar.jpg">
                <ul>
                    <li class="text">
                        {if (UID::isLoggedIn())}
                            Olá {UID::get('client_name')}
                        {else}
                            Olá Visitante
                        {/if}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- start header_btm -->
<div class="wrap">
    <div class="header_btm">
        <div class="menu-back">
            <div class="menu">
                <ul>
                    <li class="active"><a href="{$smarty.const.BASEDIR}home" changeurl>Home</a></li>
                    {foreach from=$categories item="row"}
                        <li><a href="{$smarty.const.BASEDIR}products?category_name={$row['category_name']}" changeurl>{$row['category_name']}</a></li>
                    {/foreach}
                    <div class="clear"></div>
                </ul>
            </div>
            <div id="smart_nav">
                <a class="navicon" href="#menu-left"> </a>
            </div>
            <div class="header_right">
                <ul>
                    <li><a href="{$smarty.const.BASEDIR}client/favs" changeurl><i  class="art"></i><span id="favitems" class="color1">{intval($favs)}</span></a></li>
                    <li><a href="{$smarty.const.BASEDIR}cart" changeurl><i  class="cart"></i><span id="cartitems">{intval($carts)}</span></a></li>
                </ul>
            </div>
        </div>
        <nav id="menu-left">
            <ul>
                <div class="clear"></div>
                <li><a href="{$smarty.const.BASEDIR}home">Home</a></li>
                {foreach from=$categories item="row"}
                    <li><a href="{$smarty.const.BASEDIR}products?category_name={$row['category_name']}" changeurl>{$row['category_name']}</a></li>
                {/foreach}
                <li><a href="{$smarty.const.BASEDIR}contact" changeurl>Fale Conosco</a></li>
                <li><a href="{$smarty.const.BASEDIR}client" changeurl>Minha Conta</a></li>
                <li><a href="{$smarty.const.BASEDIR}client/register" changeurl>Criar Conta</a></li>

                <div class="clear"></div>
            </ul>
        </nav>
        <div class="clear"></div>
    </div>
</div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=1443197789328925";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>