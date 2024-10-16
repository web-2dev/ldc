<form method="post" id="list" class="mt-2">
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th class="col-1"><i class="bi-pencil"></i></th>
                <th colspan="2"><?= $listName ?? "Liste" ?></th>
                <!--<th class="col-1"> <i class="bi-eraser-fill"></i></th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach($list as $item => $checked): ?>
            <tr>
                <td >
                    <label class="custom-checkbox">
                        <input type="checkbox" name="<?= $item ?>" value="true" <?= $checked ? "checked" : "" ?> class="crossout">
                        <span class="checkmark"></span>
                    </label>
                </td>

                <td colspan="2" <?= $checked ? "class='crossout'" : "" ?>><?= $item ?></td>
                
                <!-- <td class="white">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="delete[]" id="" value="<?= $item ?>">
                        <span class="checkmark cross"></span>
                    </label>
                </td> -->
            </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot >
            <tr>
                <td class="bg-secondary">
                    <button name="btDel"> <i class="bi-eraser-fill"></i> </button>
                </td>
                <td><input type="text" name="add[]" class="form-control" autofocus placeholder="ajouter un élément à la liste..."></td>
                <th>
                    <button id="btSubmit">➕</button>
                </th>
            </tr>
        </tfoot>
    </table>
</form>
