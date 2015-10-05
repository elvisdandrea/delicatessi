<div class="main_bg">
    <div class="wrap">
        <div id="main" class="main">
            <div class="contact">
                <div class="contact_left">
                    <div class="contact_info">
                        <h3>Nós estamos aqui!</h3>
                        <div id="map" class="map">

                        </div>
                    </div>
                    <div class="company_address">
                        <h3>Sobre a Delicatessi:</h3>
                        <p>Rua Evaristo da Veiga, 582</p>
                        <p>Canoas, RS</p>
                        <p>Brasil</p>
                        <p>Fone:(51) 3115-0338</p>
                        <p>Celular: (51) 9598-8243</p>
                        <p>Email: <a href="mailto:atendimento@delicatessi.com.br">atendimento@delicatessi.com.br</a></p>
                        <p>Nos siga: <a href="http://facebook.com/delicatessi">Facebook.com/delicatessi</a></p>
                    </div>
                </div>
                <div class="contact_right">
                    <div class="contact-form">
                        <h3>Fale Conosco</h3>
                        <form method="post" action="{$smarty.const.BASEDIR}contact/submit">
                            <div>
                                <span><label>Seu nome:</label></span>
                                <span><input name="userName" type="text" class="textbox"></span>
                            </div>
                            <div>
                                <span><label>E-mail</label></span>
                                <span><input name="userEmail" type="text" class="textbox"></span>
                            </div>
                            <div>
                                <span><label>Telefone</label></span>
                                <span><input name="userPhone" type="text" class="textbox"></span>
                            </div>
                            <div>
                                <span><label>Assunto</label></span>
                                <span><textarea name="userMsg"> </textarea></span>
                            </div>
                            <div>
                                <span><input type="submit" value="Enviar"></span>
                            </div>
                            <div id="mailmsg" class="alert-error" style="display: none;">

                            </div>
                        </form>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>