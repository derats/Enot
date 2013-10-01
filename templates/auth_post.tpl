{include file='header.tpl'}
<div class="row" style="height: 100px;"></div>
<div class="container">
<div class="hero-unit">
<form class="form-horizontal" autocomplete="off">
{foreach from=$auth_fields key=id item=field}
  {if $field.type == 'text' or $field.type == 'password'}
  <div class="control-group">
    <label class="control-label" for="inputEmail">{$field.name}</label>  
    <div class="controls">
      <input type="{$field.type}" name="{$id}" id="{$id}" placeholder="{$field.placeholder}" class="{$field.class}">
      <span class="help-inline"></span>
    </div>
  </div>
  {/if}
  {if $field.type == 'checkbox'}
  <div class="control-group">
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox" name="{$id}">{$field.name}
      </label>
    </div>
  </div>
  {/if}
{/foreach}
  <div class="control-group">
    <div class="controls">
      <button type="button" class="btn" id="post">Просмотр заявок</button>
    </div>
  </div>
</form>
</div>
</div>
<div class="container" id="console">
</div>
{include file='footer.tpl'}