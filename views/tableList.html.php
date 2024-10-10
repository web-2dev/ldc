<form method="post" id="list" class="mt-2">
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th class="col-1"><i class="bi-pencil"></i></th>
                <th><?= $listName ?? "Liste" ?></th>
                <th class="col-1"><i class="bi-eraser-fill"></i></th>
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

                <td <?= $checked ? "class='crossout'" : "" ?>><?= $item ?></td>
                
                <td class="bg-secondary">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="delete[]" id="" value="<?= $item ?>">
                        <span class="checkmark cross"></span>
                    </label>                
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot >
            <tr>
                <td>➕</td>
                <td><input type="text" name="add[]" class="form-control" autofocus placeholder="ajouter un élément à la liste..."></td>
                <th class="bg-secondary">
                    <button name="btDel"><i class="bi bi-trash3"></i>
                    </button>
                </th>
            </tr>
        </tfoot>
    </table>
</form>
