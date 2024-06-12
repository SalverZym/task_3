<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="news-detail">

	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<div class="article-card__date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div>
	<?endif;?>

	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>

	<div class="article-card__image sticky">
		<img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" data-object-fit="cover"/>
    </div>

	<?endif?>
	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h3><?=$arResult["NAME"]?></h3>
	<?endif;?>

	<div class="article-card__text">
		<div class="block-content" data-anim="anim-3">
			<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
			<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
		<?endif;?>
		<?if($arResult["NAV_RESULT"]):?>
			<?if($arParams["DISPLAY_TOP_PAGER"]):?><p><?=$arResult["NAV_STRING"]?></p><?endif;?>
			<?echo $arResult["NAV_TEXT"];?>
			<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><p><?=$arResult["NAV_STRING"]?></p><?endif;?>
		<?elseif($arResult["DETAIL_TEXT"] <> ''):?>
			<?echo $arResult["DETAIL_TEXT"];?>
		<?else:?>
			<?echo $arResult["PREVIEW_TEXT"];?>
		<?endif?>
		<div style="clear:both"></div>
		
		<?foreach($arResult["FIELDS"] as $code=>$value):?>
			<?if ($code != 'PREVIEW_PICTURE'):?>
				<p>
					<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
				</p>
			<?endif?>
		<?endforeach;?>
		
		<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
			<?if($pid != "THEME"):?>
				<div class="news-property"><?=$arProperty["NAME"]?>:&nbsp;
				<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
					<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
				<?else:?>
					<?=$arProperty["DISPLAY_VALUE"];?>
				<?endif?>
				</div>
			<?endif?>
		<?endforeach;?>
			<div class="news-property">
				<?=GetMessage("T_NEWS_SHORT_URL");
				$shortPageURL = (CMain::IsHTTPS()) ? "https://" : "http://";
				$host = (SITE_SERVER_NAME == "") ?  $_SERVER['HTTP_HOST'] : SITE_SERVER_NAME;
				$shortPageURL.= htmlspecialcharsbx($host).CBXShortUri::GetShortUri($arResult["~DETAIL_PAGE_URL"]);
				?>
				<a href="<?=$shortPageURL?>"><?=$shortPageURL?></a>
			</div>
		</div>
	</div>

	<div class="article-card__button"><a href="<?=$arResult["SECTION_URL"]?>">Назад к новостям</a></div>
	<?
	if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
	{
		?>
		<div class="news-detail-share">
			<noindex>
			<?
			$APPLICATION->IncludeComponent("bitrix:main.share", "", array(
					"HANDLERS" => $arParams["SHARE_HANDLERS"],
					"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE" => $arResult["~NAME"],
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE" => $arParams["SHARE_HIDE"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);
			?>
			</noindex>
		</div>
		<?
	}
	?>
	<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
		<?if($pid == "THEME" && count($arResult["ITEMS_THEME"]) > 0 ):?>
			<div class="news-detail-theme">
			<div class="news-theme-title"><?=GetMessage("T_NEWS_DETAIL_THEME")?>:&nbsp;
				<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
				<?=implode(",&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
			<?else:?>
				<?=$arProperty["DISPLAY_VALUE"];?>
			<?endif?>
			</div>
			<?foreach($arResult["ITEMS_THEME"] as $pid=>$arProperty):?>
				<div class="news-theme-item"><div class="news-theme-date"><?=$arProperty["ACTIVE_FROM"]?></div><div class="news-theme-url"><a href="<?=$arProperty["DETAIL_PAGE_URL"]?>"><?=$arProperty["NAME"]?></a></div></div>
			<?endforeach;?>
			<div class="br"></div>
			</div>
		<?endif?>
	<?endforeach;?>
	
	
</div>
