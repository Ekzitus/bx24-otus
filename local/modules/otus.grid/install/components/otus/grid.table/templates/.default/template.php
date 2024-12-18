<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if (isset($arResult['ERROR'])): ?>
    <div style="color: red;">
        <?= htmlspecialcharsbx($arResult['ERROR']) ?>
    </div>
<?php else: ?>
    <table class="data-table">
        <thead>
        <tr>
            <?php
            if (!empty($arResult['TABLE_DATA'])):
                $firstRow = reset($arResult['TABLE_DATA']);
                foreach ($firstRow as $column => $value):
                    echo "<th>" . htmlspecialcharsbx($column) . "</th>";
                endforeach;
            endif;
            ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($arResult['TABLE_DATA'] as $row): ?>
            <tr>
                <?php foreach ($row as $column => $value): ?>
                    <td><?= htmlspecialcharsbx($value) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
