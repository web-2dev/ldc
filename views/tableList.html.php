<form action="bin/list.php"  method="post" id="list" class="mt-2">
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th class="col-1"><i class="bi-pencil"></i></th>
                <th colspan="2"><i class="bi-list"></i> <?= $listName ?? "Liste" ?></th>
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

                <td colspan="2" class="td-edit <?= $checked ? "crossout" : "" ?>">
                    <span class="delius-regular "><?= $item ?></span>
                    <input class="hide edit" name="modif[]" value="<?= $item ?>" id="input<?= $item ?>" >
                </td>                
            </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot >
            <tr>
                <td class="bg-secondary">
                    <button type="button" name="btDel" class="form-control" id="btDel"> <i class="bi-eraser-fill"></i> </button>
                </td>
                <td><input type="text" name="add" class="form-control" autofocus placeholder="ajouter un élément à la liste..."></td>
                <th>
                    <button type="submit" id="btAdd" class="btn form-control btn-secondary" ><i class="bi-clipboard-plus"></i></button>
                </th>
            </tr>
        </tfoot>
    </table>
</form>
