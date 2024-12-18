<?php
/** @global CMain $APPLICATION */
$module_id = "otus.grid";
$right = $APPLICATION->GetGroupRight($module_id);

if ($right >= "R"):

    IncludeModuleLangFile(__FILE__);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajax"]) && $_POST["ajax"] == "Y" && check_bitrix_sessid()) {
        if ($right == "W" && isset($_POST["test"])) {
            COption::SetOptionString($module_id, "test", $_POST["test"]);
            echo json_encode(["status" => "success", "message" => GetMessage("OTUS_GRID_OPTION_SAVED")]);
        } else {
            echo json_encode(["status" => "error", "message" => GetMessage("OTUS_GRID_ACCESS_DENIED")]);
        }
        die();
    }

    $testValue = COption::GetOptionString($module_id, "test", "");

    ?>
    <form id="otus-grid-options-form">
        <?= bitrix_sessid_post() ?>
        <table class="adm-detail-content-table edit-table">
            <tr>
                <td width="50%"><label for="test"><?= GetMessage("OTUS_GRID_OPTION_TEST") ?>:</label></td>
                <td width="50%"><input type="text" name="test" id="test" value="<?= htmlspecialcharsbx($testValue) ?>"
                                       size="40"></td>
            </tr>
        </table>
        <button type="button" id="save-button" class="adm-btn-save"><?= GetMessage("MAIN_SAVE") ?></button>
        <div id="status-message" style="margin-top: 10px;"></div>
    </form>

    <script>
        document.getElementById("save-button").addEventListener("click", function () {
            const form = document.getElementById("otus-grid-options-form");
            const formData = new FormData(form);
            formData.append("ajax", "Y");

            fetch(form.action, {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    const statusMessage = document.getElementById("status-message");
                    statusMessage.textContent = data.message;
                    statusMessage.style.color = data.status === "success" ? "green" : "red";
                })
                .catch(error => {
                    console.error("Ошибка сохранения:", error);
                    document.getElementById("status-message").textContent = "Произошла ошибка при сохранении.";
                });
        });
    </script>
<?php
endif;