<div class="top_bg">
    <div class="wrap">
        <div class="header">
            <div class="logo">
                <a href="index.html"><img src="{$smarty.const.T_IMGURL}/logo.png" alt=""/></a>
            </div>
            <div class="log_reg">
                <ul>
                    <li><a href="login.html">Minha Conta</a> </li>
                    <span class="log"> | </span>
                    <li><a href="register.html">Criar Conta</a> </li>
                    <div class="clear"></div>
                </ul>
            </div>
            <div class="web_search">
                <form>
                    <input type="text" value="">
                    <input type="submit" value=" " />
                </form>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<!-- start header_btm -->
<div class="wrap">
    <div class="header_btm">
        <div class="menu">
            <ul>
                <li class="active"><a href="{$smarty.const.BASEDIR}home" changeurl>Home</a></li>
                {foreach from=$categories item="row"}
                    <li><a href="{$smarty.const.BASEDIR}products?category_name={$row['category_name']}" changeurl>{$row['category_name']}</a></li>
                {/foreach}
                <li><a href="{$smarty.const.BASEDIR}contact" changeurl>Contato</a></li>
                <div class="clear"></div>
            </ul>
        </div>
        <div id="smart_nav">
            <a class="navicon" href="#menu-left"> </a>
        </div>
        <nav id="menu-left">
            <ul>
                <li><form>
                        <input type="text" value="">
                        <input type="submit" value=" " />
                    </form>
                </li>
                <div class="clear"></div>
                <li><a href="{$smarty.const.BASEDIR}home">Home</a></li>
                {foreach from=$categories item="row"}
                    <li><a href="{$smarty.const.BASEDIR}products?category_name={$row['category_name']}" changeurl>{$row['category_name']}</a></li>
                {/foreach}
                <li><a href="{$smarty.const.BASEDIR}contact" changeurl>Contato</a></li>
                <li><a href="{$smarty.const.BASEDIR}profile" changeurl>Minha Conta</a></li>
                <li><a href="{$smarty.const.BASEDIR}profile/new" changeurl>Criar Conta</a></li>

                <div class="clear"></div>
            </ul>
        </nav>
        <div class="header_right">
            <ul>
                <li><a href="#"><i  class="art"></i><span class="color1">30</span></a></li>
                <li><a href="#"><i  class="cart"></i><span>0</span></a></li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>