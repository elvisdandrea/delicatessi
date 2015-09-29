<div id="addaddressform" class="registration_form">
    {if (count($address) == 0)}
        <label>Cep não encontrado</label>
    {else}
        <form method="post" action="cart/addaddress">
            <label>Endereço:</label><label>{$address['logradouro']}</label>
            <input type="hidden" name="street_addr" value="{$address['logradouro']}">
            <label>Número:</label>
            <input type="text" name="street_number" placeholder="Número" required />
            <label>Complemento:</label><input type="text" name="street_additional" placeholder="Complemento" />
            <label>Bairro:</label><label>{$address['bairro']}</label>
            <input type="hidden" name="hood" value="{$address['bairro']}">
            <label>Cidade:</label><label>{$address['localidade']}</label>
            <input type="hidden" name="city" value="{$address['localidade']}">
            <label>UF:</label><label>{$address['uf']}</label>
            <input type="hidden" name="state" value="{$address['uf']}">
            <input type="hidden" name="zip_code" value="{$address['cep']}">
            <input class="btn" type="submit" value="Adicionar Endereço" />
        </form>

    {/if}
</div>