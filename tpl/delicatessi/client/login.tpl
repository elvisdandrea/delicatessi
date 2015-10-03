<div class="main_bg">
    <div class="wrap">
        <div class="main">
            <div class="login_left">
                <h3>Novo Cliente?</h3>
                <p>Crie sua conta e efetue rapidamente a compra de produtos, além de armazenar sua lista de itens favoritos.</p>
                <a href="{$smarty.const.BASEDIR}client/register" class="btn">
                    Criar minha conta
                </a>
            </div>
            <div class="login_left">
                <h3>Já sou cadastrado</h3>
                <p>Se você já é cadastrado, por favor faça o login</p>
                <!-- start registration -->
                <div class="registration">
                    <div class="registration_left">
                        <a href="#"><div class="reg_fb"><img src="web/images/facebook.png" alt=""><i>Login com Facebook</i><div class="clear"></div></div></a>
                        <div class="registration_form">
                            <!-- Form -->
                            <form id="registration_form" action="{$smarty.const.BASEDIR}client/login" method="post">
                                <div>
                                    <label>
                                        <input placeholder="E-Mail:" type="email" name="email" tabindex="3" required="">
                                    </label>
                                </div>
                                <div>
                                    <label>
                                        <input placeholder="Senha" name="passwd" type="password" tabindex="4" required="">
                                    </label>
                                </div>
                                <div>
                                    <input type="submit" value="Entrar" id="register-submit">
                                    <div id="loginmsg" class="alert-error" style="display: none"></div>
                                </div>
                                <div class="forget">
                                    <a href="{$smarty.const.BASEDIR}client/forgotpwd">Esqueci minha senha!</a>
                                </div>
                            </form>
                            <!-- /Form -->
                        </div>
                    </div>
                </div>
                <!-- end registration -->
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>