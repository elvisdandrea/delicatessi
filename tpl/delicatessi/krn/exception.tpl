
<div class="banner">
    <h1>
        <img src="{$smarty.const.T_IMGURL}/logo.png" alt="cerberus_logo" width="90px"/>
        Desculpe pelo transtorno!</h1>
    <div class="message">
        {if (ENVDEV == '0')}
            <label>Parece que algum acesso ao sistema não ocorreu como deveria ='(.</label>
            <label>Por favor, informe isto para nós em nossa <a href="{$smarty.const.BASEDIR}contact">Página de Contato</a>.</label>
        {else}
            <label>
                {$error['message']} <br>
                <hr>
                {if (isset($error['file']))}
                    File: {$error['file']} <br>
                    Line: {$error['line']}
                    <hr>
                {/if}
                <label>Trace:</label>
            {foreach from=$trace item="action"}
                {if (isset($action['file']))}
                    <hr>
                    <ul>
                        <li>File: {$action['file']}</li>
                        <li>Line: {$action['line']}</li>
                        <li>Class: {$action['class']}</li>
                        <li>Function: {$action['function']}</li>
                    </ul>
                {/if}
            {/foreach}
            </label>
        {/if}
    </div>
</div>
