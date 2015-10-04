<div id="addaddressform" class="registration_form purchase_form">
    {if (count($address) == 0)}
        <label>Cep não encontrado</label>
    {else}
        <form method="post" action="cart/addaddress{$asoption}">
            <p><label>Endereço:</label><label class="value">{$address['logradouro']}</label></p>
            <input type="hidden" name="street_addr" value="{$address['logradouro']}">
            <p><label>Número:</label><input type="text" name="street_number" placeholder="Número" required /></p>
            <p><label>Complemento:</label><input type="text" name="street_additional" placeholder="Complemento" /></p>
            <p><label>Bairro:</label><label class="value">{$address['bairro']}</label></p>
            <input type="hidden" name="hood" value="{$address['bairro']}">
            <p><label>Cidade:</label><label class="value">{$address['localidade']}</label></p>
            <input type="hidden" name="city" value="{$address['localidade']}">
            <p><label>UF:</label><label class="value">{$address['uf']}</label></p>
            <input type="hidden" name="state" value="{$address['uf']}">
            <input type="hidden" name="zip_code" value="{$address['cep']}">
            <p><input class="btn" type="submit" value="Adicionar Endereço" /></p>
        </form>

    {/if}
</div>