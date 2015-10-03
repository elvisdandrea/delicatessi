<div class="main_bg">
    <div class="wrap">
        <div id="main" class="main">
            <div class="contact profile">
                <div class="contact_left">
                    <div class="contact_info">
                        <h3>{$profile['client_name']}</h3>
                    </div>
                    <img src="{if ($profile['image'] != '')}{$profile['image']}{else}{$smarty.const.T_IMGURL}/no_avatar.jpg{/if}">
                    <div class="company_address profile-btn">
                        <a class="btn btn-small" href="{$smarty.const.BASEDIR}cart" changeurl>Acessar Meu Carrinho</a>
                        <a class="btn btn-small" href="{$smarty.const.BASEDIR}client/favs" changeurl>Acessar Meus Favoritos</a>
                        <a class="btn btn-small" href="{$smarty.const.BASEDIR}client/orders" changeurl>Acessar Meus Pedidos</a>
                    </div>
                </div>
                <div class="contact_right">
                    <div class="contact-form">
                        <span >E-mail:</span>
                        {$profile['email']}
                        <span >Telefones:</span>
                        {foreach from=$phoneList item="phone"}
                            <ul>
                                <li>{$phone['phone_number']}</li>
                            </ul>
                        {/foreach}
                        <span >Endereços de entrega:</span>
                        {foreach from=$addressList item="address"}
                            <ul id="addresslist">
                                <li>{$address['street_addr']},{$address['street_number']} {$address['street_additional']},{$address['hood']},{$address['city']} - {$address['state']}  <a class="link-remove" href="{$smarty.const.BASEDIR}client/removeaddr?id={$address['id']}">Remover</a></li>
                            </ul>
                        {/foreach}
                        <hr>
                        <h3>Adicionar um endereço de entrega</h3>
                        <div >
                            <div class="registration_form">
                                <form method="post" id="newaddress" action="{$smarty.const.BASEDIR}cart/getzipaddress">
                                    <div class="form-grid">
                                        <div class="col-12">
                                            <label>Digite o CEP e clique em BUSCAR</label>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-6">
                                                <input type="text" name="cep" placeholder="CEP:"/>
                                            </div>
                                            <div class="col-6">
                                                <input class="" type="submit" value="Buscar"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="resultzip" class="">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>