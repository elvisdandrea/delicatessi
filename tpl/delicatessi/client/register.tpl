<div class="main_bg">
    <div class="wrap">
        <div class="main">
            <div class="login_left">
                <h3>Login de Cliente</h3>
                <p>Se você já tem uma conta conosco, por favor faça seu login.</p>
                <!-- start registration -->
                <div class="registration">
                    <div class="registration_left">
                       <!-- <a href="{$smarty.const.BASEDIR}client/loginfacebook{if ($product_id)}?product_id={$product_id}{/if}"><div class="reg_fb"><img src="{$smarty.const.T_IMGURL}/facebook.png" alt=""><i>Login com Facebook</i><div class="clear"></div></div></a>-->
                        <div class="registration_form">
                            <!-- Form -->
                            <form id="registration_form" action="{$smarty.const.BASEDIR}client/login{if ($product_id)}?product_id={$product_id}{/if}" method="post">
                                <div>
                                    <label>
                                        <input placeholder="email:" type="email" name="email" tabindex="3" required="">
                                    </label>
                                </div>
                                <div>
                                    <label>
                                        <input placeholder="password" type="password" name="passwd" tabindex="4" required="">
                                    </label>
                                </div>
                                <div>
                                    <input type="submit" value="Acessar" id="register-submit">
                                </div>
                                <div class="forget">
                                    <a href="{$smarty.const.BASEDIR}client/forgotpwd">Esqueci minha senha</a>
                                </div>
                            </form>
                            <!-- /Form -->
                        </div>
                    </div>
                </div>
                <!-- end registration -->
            </div>
            <div class="login_left">
                <h3>Criar uma nova conta</h3>
                <p>Crie sua conta e efetue rapidamente a compra de produtos, além de armazenar sua lista de itens favoritos.</p>
                <div class="registration_left">
                    <!--<a href="{$smarty.const.BASEDIR}client/registerfacebook{if ($product_id)}?product_id={$product_id}{/if}"><div class="reg_fb"><img src="{$smarty.const.T_IMGURL}/facebook.png" alt=""><i>Criar conta com Facebook</i><div class="clear"></div></div></a>-->
                    <div class="registration_form">
                        <!-- Form -->
                        <form id="registration_form" action="{$smarty.const.BASEDIR}client/registerclient{if ($product_id)}?product_id={$product_id}{/if}" method="post">
                            <div>
                                <label>
                                    <input placeholder="Nome:" name="client_name" type="text" tabindex="1" required="" autofocus="">
                                </label>
                            </div>
                            <div>
                                <label>
                                    <input placeholder="Sobrenome:" name="client_lastname" type="text" tabindex="2" autofocus="">
                                </label>
                            </div>
                            <div>
                                <label>
                                    <input placeholder="Telefone:" name="phone_number" type="text" tabindex="3" required="">
                                </label>
                            </div>
                            <div>
                                <label>
                                    <input placeholder="E-mail:" name="email" type="email" tabindex="3" required="">
                                </label>
                            </div>
                            <div>
                                <label>
                                    <input placeholder="Senha:" name="passwd" type="password" tabindex="4" required="">
                                </label>
                            </div>
                            <div>
                                <label>
                                    <input placeholder="Repetir senha:" name="retype_passwd" type="password" tabindex="4" required="">
                                </label>
                            </div>
                            <div>
                                <input type="submit" value="Criar minha conta" id="register-submit">
                            </div>
                            <div id="loginmsg" class="alert-error" style="display: none"></div>
                        </form>
                        <!-- /Form -->
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>