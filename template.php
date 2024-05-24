<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
//debug($GLOBALS);
$today = new DateTime();
?>

<?php


function getValueByKey($key) {
    $mnemonik = json_decode(file_get_contents('http://10.10.110.38:8080/upload/main/jsons/mnemonik.json'), true);
    return $mnemonik[$key]; 
}
?>
<? if ($arResult["ITEMS"]) : ?>
    <input type="checkbox" id="checkbox" name="checkbox" checked="checked" onclick="toggleCheckbox(this)">
    <label for="checkbox">Предаставить в виде таблицы</label>

<? endif; ?>
<? if ($arResult["ITEMS"]) : ?>
<div class="results__table__wrapper">
<ul class="results__table__header">
  <li class="results__table__header__list">
    <span class="results__table__block results__table__block_header results__table__block__culture">Род и Вид</span>
    <span class="results__table__block results__table__block_header results__table__block__code">Код</span>
    <span class="results__table__block results__table__block_header results__table__block__name">Название</span>
    <span class="results__table__block results__table__block_header results__table__block__year">Год</span>
    <span class="results__table__block results__table__block_header results__table__block__regions">Регионы допуска</span>
    <div class="results__table__block results__table__block__params">
      <p class="results__table__block results__table__block_header results__table__block__params__title">Признак</p>
      <div class="results__table__block__params__list">
        <div class="results__table__block__params__item results__table__block__params__item_1">1
          <span class="results__table__popup results__table__popup__params_1">Категория</span>
        </div>
        <div class="results__table__block__params__item results__table__block__params__item_2">2
          <span class="results__table__popup results__table__popup__params_2">Направление использования</span>
        </div>
        <div class="results__table__block__params__item results__table__block__params__item_3">3
          <span class="results__table__popup results__table__popup__params_3">Период потребления</span>
        </div>
        <div class="results__table__block__params__item results__table__block__params__item_4">4
          <span class="results__table__popup results__table__popup__params_4">Срок созревания (гр. спелости)</span>
        </div>
        <div class="results__table__block__params__item results__table__block__params__item_5">5
          <span class="results__table__popup results__table__popup__params_5">Тип растения</span>
        </div>
        <div class="results__table__block__params__item results__table__block__params__item_6">6
          <span class="results__table__popup results__table__popup__params_6">Условия выращивания</span>
        </div>
        <div class="results__table__block__params__item results__table__block__params__item_7">7
          <span class="results__table__popup results__table__popup__params_7">Форма</span>
        </div>
      </div>
    </div>
    <span class="results__table__block results__table__block_header results__table__block__info">Дополнительная информация</span>
  </li>
</ul>
<hr class="results__table__hr" />     
<ul class="results__table__list">
<? foreach($arResult["ITEMS"] as $arItem) : ?>
  <?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    if ($arItem['IBLOCK_SECTION_ID'] == 29) $culture = 'Культура';
    else if ($arItem['IBLOCK_SECTION_ID'] == 30) $culture = 'Породы';
    ?>
    <li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
      <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="results__table__link">
        <span class="results__table__block results__table__block__culture"><?=$arItem["PROPERTIES"]["CULTURE_NAME"]["VALUE"]?> (<?=$arItem["PROPERTIES"]["CULTURE_GROUP_NAME"]["VALUE"]?>)</span>
        <span class="results__table__block results__table__block__code"><?=$arItem["PROPERTIES"]["SORT_ID"]["VALUE"]?></span>
        <span class="results__table__block results__table__block__name"><?=$arItem["NAME"]?></span>
        <span class="results__table__block results__table__block__year"><?=$arItem["PROPERTIES"]["ALLOW_YEAR"]["VALUE"]?></span>
        <div class="results__table__block results__table__block__regions">
          <?php if (!empty($arItem["PROPERTIES"]["REGIONS"]["VALUE_SORT"])) : ?>
            <?php if (count($arItem["PROPERTIES"]["REGIONS"]["VALUE_SORT"]) == 12) : ?>
              <span class="results__table__region">*</span>
            <?php else : ?>
              <?php foreach ($arItem["PROPERTIES"]["REGIONS"]["VALUE_SORT"] as $index => $region) { ?>
                <span class="results__table__region"><?= $region ?></span>
                <?php if ($index < count($arItem["PROPERTIES"]["REGIONS"]["VALUE_SORT"]) - 1) : ?>
                  ,
                <?php endif; ?>
              <?php } ?>
            <?php endif; ?>
          <?php elseif (!empty($arItem["PROPERTIES"]["ZONES"]["VALUE"])) : ?>
            <?php foreach ($arItem["PROPERTIES"]["ZONES"]["VALUE"] as $index => $zone) { ?>
              <?php
                $firstWord = explode(' ', $zone)[0];
                if (preg_match('/^[IVXLCDM]+$/', $firstWord)) {
              ?>
                <span class="results__table__zone"><?= $firstWord ?></span>
                <?php if ($index < count($arItem["PROPERTIES"]["ZONES"]["VALUE"]) - 1) : ?>
                  ,
                <?php endif; ?>
              <?php } ?>
            <?php } ?>
          <?php elseif (empty($arItem["PROPERTIES"]["REGIONS"]["VALUE_SORT"]) && empty($arItem["PROPERTIES"]["ZONES"]["VALUE"])) : ?>
            <span class="results__table__region">*</span>
          <?php endif; ?>
          
        </div>
        <div class="results__table__block results__table__block__additional">
            <div class="results__table__block results__table__block__params__value results__table__block__params__value_1">
            <?php if ($arItem["PROPERTIES"]["CHARACT_1"]["VALUE"]) : ?>
                <?php
                $value1 = getValueByKey($arItem["PROPERTIES"]["CHARACT_1"]["VALUE"]);
                echo $value1;
                ?>
                <span class="results__table__popup results__table__popup__value_1"><?=$arItem["PROPERTIES"]["CHARACT_1"]["VALUE"]?></span>
            <?php endif; ?>
            </div>
            <div class="results__table__block results__table__block__params__value results__table__block__params__value_2">
            <?php if ($arItem["PROPERTIES"]["CHARACT_2"]["VALUE"]) : ?>
                <?php
                $value2 = getValueByKey($arItem["PROPERTIES"]["CHARACT_2"]["VALUE"]);
                echo $value2;
                ?>
                <span class="results__table__popup results__table__popup__value_2"><?=$arItem["PROPERTIES"]["CHARACT_2"]["VALUE"]?></span>
            <?php endif; ?>
            </div>
            <div class="results__table__block results__table__block__params__value results__table__block__params__value_3">
            <?php if ($arItem["PROPERTIES"]["CHARACT_3"]["VALUE"]) : ?>
                <?php
                $value3 = getValueByKey($arItem["PROPERTIES"]["CHARACT_3"]["VALUE"]);
                echo $value3;
                ?>
                <span class="results__table__popup results__table__popup__value_3"><?=$arItem["PROPERTIES"]["CHARACT_3"]["VALUE"]?></span>
            <?php endif; ?>
            </div>
            <div class="results__table__block results__table__block__params__value results__table__block__params__value_4">
            <?php if ($arItem["PROPERTIES"]["CHARACT_4"]["VALUE"]) : ?>
                <?php
                $value4 = getValueByKey($arItem["PROPERTIES"]["CHARACT_4"]["VALUE"]);
                echo $value4;
                ?>
                <span class="results__table__popup results__table__popup__value_4"><?=$arItem["PROPERTIES"]["CHARACT_4"]["VALUE"]?></span>
            <?php endif; ?>
            </div>
            <div class="results__table__block results__table__block__params__value results__table__block__params__value_5">
            <?php if ($arItem["PROPERTIES"]["CHARACT_5"]["VALUE"]) : ?>
                <?php
                $value5 = getValueByKey($arItem["PROPERTIES"]["CHARACT_5"]["VALUE"]);
                echo $value5;
                ?>
                <span class="results__table__popup results__table__popup__value_5"><?=$arItem["PROPERTIES"]["CHARACT_5"]["VALUE"]?></span>
            <?php endif; ?>
            </div>
            <div class="results__table__block results__table__block__params__value results__table__block__params__value_6">
            <?php if ($arItem["PROPERTIES"]["CHARACT_6"]["VALUE"]) : ?>
                <?php
                $value6 = getValueByKey($arItem["PROPERTIES"]["CHARACT_6"]["VALUE"]);
                echo $value6;
                ?>
                <span class="results__table__popup results__table__popup__value_6"><?=$arItem["PROPERTIES"]["CHARACT_6"]["VALUE"]?></span>
            <?php endif; ?>
            </div>
            <div class="results__table__block results__table__block__params__value results__table__block__params__value_7">
            <?php if ($arItem["PROPERTIES"]["CHARACT_7"]["VALUE"]) : ?>
                <?php
                $value7 = getValueByKey($arItem["PROPERTIES"]["CHARACT_7"]["VALUE"]);
                echo $value7;
                ?>
                <span class="results__table__popup results__table__popup__value_7"><?=$arItem["PROPERTIES"]["CHARACT_7"]["VALUE"]?></span>
            <?php endif; ?>
            </div>
        </div>
        <div class="results__table__block results__table__block__info results__table__block__info_value">
          <? if ($arItem["PROPERTIES"]["ALLOW_DATE"]["VALUE"]) : ?> <span class="results__table__allow"></span><span class="results__table__allow__text">Дата регистрации заявки на допуск: <?=formatedDate($arItem["PROPERTIES"]["ALLOW_DATE"]["VALUE"], false)?></span><? endif; ?>
          
          <? $patent_end = new DateTime($arItem["PROPERTIES"]["PATENT_END"]["VALUE"]); ?>
          <? if ($arItem["PROPERTIES"]["PATENT_NUMBER"]["VALUE"] != '' && $patent_end > $today) : ?>
              <span class="results__table__patent"></span><span class="results__table__patent__text">Номер патента: <?=$arItem["PROPERTIES"]["PATENT_NUMBER"]["VALUE"]?> от <?=formatedDate($arItem["PROPERTIES"]["PATENT_START"]["VALUE"], false)?>г.</span>
          <? endif; ?>
          
          <? if ($arItem["PROPERTIES"]['LIC_DATE']["VALUE"]) : ?>
              <? $curdate = date('d.m.Y'); ?>
              <? $nums = 0; ?>
              <? foreach ($arItem["PROPERTIES"]['LIC_DATE_END']["VALUE"] as $date) : ?>
                      <? 
                          $today_time = strtotime($curdate);
                          $expire_time = strtotime($date);
                          if ($expire_time >= $today_time) $nums++;
                      ?>
              <? endforeach; ?>
          <span class="results__table__license"></span><span class="results__table__license__text">Лицензионные договоры: <?=count($arItem["PROPERTIES"]['LIC_DATE_END']["VALUE"])?>, действующих <?=$nums?></span>
          <? endif; ?>
        </div>
      </a>
    </li>     
<?endforeach;?>
</ul>



<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>


<? else: ?>
<p>Ничего не найдено.</p>

<? endif; ?>
</div>
<div class="results__cards__wrapper">
<? if ($arResult["ITEMS"]) : ?>
<ul class="results__list">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	
    if ($arItem['IBLOCK_SECTION_ID'] == 29) $culture = 'Культура';
    else if ($arItem['IBLOCK_SECTION_ID'] == 30) $culture = 'Породы';
    
    ?>
            
    <li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="results__link">
            <span class="results__name"><?=$arItem["NAME"]?></span>
            <? echo $culture; ?>: <?=$arItem["PROPERTIES"]["CULTURE_NAME"]["VALUE"]?> (<?=$arItem["PROPERTIES"]["CULTURE_GROUP_NAME"]["VALUE"]?>)<br>
            <? if ($arItem["PROPERTIES"]["CHARACT_1"]["VALUE"]) : ?>
            Категория: <?= $arItem["PROPERTIES"]["CHARACT_1"]["VALUE"]?> <br>
            <? endif; ?>
            <? if ($arItem["PROPERTIES"]["ALLOW_YEAR"]["VALUE"]) : ?> <span class="results__allow">Год включения: <?=$arItem["PROPERTIES"]["ALLOW_YEAR"]["VALUE"]?>г.</span><? endif; ?>
            
            <? $patent_end = new DateTime($arItem["PROPERTIES"]["PATENT_END"]["VALUE"]); ?>
            <? if ($arItem["PROPERTIES"]["PATENT_NUMBER"]["VALUE"] != '' && $patent_end > $today) : ?>
                <span class="results__patent"><span>Номер патента: <?=$arItem["PROPERTIES"]["PATENT_NUMBER"]["VALUE"]?> от <?=formatedDate($arItem["PROPERTIES"]["PATENT_START"]["VALUE"], false)?>г.</span></span>
            <? endif; ?>
            
            <? if ($arItem["PROPERTIES"]['LIC_DATE']["VALUE"]) : ?>
                <? $curdate = date('d.m.Y'); ?>
                <? $nums = 0; ?>
                <? foreach ($arItem["PROPERTIES"]['LIC_DATE_END']["VALUE"] as $date) : ?>
                        <? 
                            $today_time = strtotime($curdate);
                            $expire_time = strtotime($date);
                            if ($expire_time >= $today_time) $nums++;
                        ?>
                <? endforeach; ?>
            <span class="results__license"><span>Лицензионные договоры: <?=count($arItem["PROPERTIES"]['LIC_DATE_END']["VALUE"])?>, действующих <?=$nums?></span></span>
            <? endif; ?>
            
            <span class="results__arrow">Перейти</span>
        </a>
    </li>     
        
<?endforeach;?>
</ul>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>

<? else: ?>
<p>Ничего не найдено.</p>

<? endif; ?>
</div>


<script>
  var properties = <?php echo json_encode($arItem["PROPERTIES"]); ?>;
  console.log(properties);

  const tableWrapper = document.querySelector('.results__table__wrapper');
  const cardWrapper = document.querySelector('.results__cards__wrapper');

  tableWrapper.style.display = 'none';
  cardWrapper.style.display = 'block';

  function toggleCheckbox(checkbox) {
    checkbox.checked = !checkbox.checked;
    if (checkbox.checked) {
      document.getElementById('checkbox').checked = true;
      tableWrapper.style.display = 'block';
      cardWrapper.style.display = 'none';
    }
    else {
      document.getElementById('checkbox').checked = false;
      tableWrapper.style.display = 'none';
      cardWrapper.style.display = 'block';
    }
  }
</script>