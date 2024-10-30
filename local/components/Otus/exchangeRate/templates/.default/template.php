<div style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; text-align: center;">
    <div style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); padding: 20px; max-width: 400px; margin: auto;">
        <h1 style="color: #333;">Курс валюты</h1>
        <div style="font-size: 24px; margin: 10px 0;">
            1 <?php echo $arResult['CURRENCY'] ?> =
            <span style="font-size: 32px; color: #4CAF50;">
                <?php echo $arResult['RATE'] ?> <?php echo $arResult['BASE_CURRENCY'] ?>
            </span>
        </div>
        <div style="font-size: 14px; color: #777;">Обновлено: <?php echo $arResult['DATE_CREATE'] ?></div>
    </div>
</div>