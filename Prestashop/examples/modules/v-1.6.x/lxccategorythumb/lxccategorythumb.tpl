{foreach from=$cats item=cat name=cat_list}
    <div>
        <a href="{$cat.link}">
            <p>{$cat.name}</p>     
        </a>
        <img src="{$cat.link_thumb}"/>
    </div>
{/foreach}