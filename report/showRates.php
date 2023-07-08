<?php
require_once './config/config.php';
require_once './database/connect.php';
require_once('./views/Layouts/header.php');

$page = 0;

if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

$amount = $page * 10;

$sql = "SELECT * FROM rates ORDER BY amount ASC";
$rates = $conn->query($sql);

?>
<div class="rtl max-w-5xl mx-auto py-20 sm:px-6 lg:px-8">
    <div class="mb-3">
        <a href="./registerRates.php" class=" flex items-center w-52 bg-indigo-500 hover:bg-indigo-400 rounded-md text-white px-4 py-2">
            <i class="px-2 material-icons hover:cursor-pointer">add_circle_outline</i>
            ثبت نرخ ارز جدید</a>
    </div>
    <table class="min-w-full text-left text-sm font-light">
        <thead class="font-medium dark:border-neutral-500">
            <tr class="bg-green-700">
                <th scope="col" class="px-3 py-3 text-white text-center">
                    نرخ ارز
                </th>
                <th scope="col" class="px-3 py-3 text-white text-center">
                    شاخص نرخ
                </th>
                <th scope="col" class="px-3 py-3 text-white text-center">
                    زنگ شاخص
                </th>
                <th scope="col" class="px-3 py-3 text-white text-center">
                    انتخاب به عنوان پیش فرض
                </th>
                <th scope="col" class="px-3 py-3 text-white text-center">
                    عملیات
                </th>
            </tr>
        </thead>
        <tbody id="results">
            <?php
            if ($rates->num_rows > 0) {
                while ($rate = $rates->fetch_assoc()) {
            ?>
                    <tr v-if="rates.length > 0" v-for="item in rates" class="transition duration-300 ease-in-out bg-neutral-200 hover:bg-neutral-100">
                        <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                            <?php echo $rate['amount'] ?>
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                            <?php echo $rate['status'] ?>
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 text-center font-bold <?php echo $rate['status'] ?>">
                            <?php ?>
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                            <input type="checkbox" name="selected" id="selected" class="cursor-pointer" <?php if ($rate['selected'] == 1) echo 'checked' ?> data-id="<?php echo $rate['id'] ?>" onclick="toggleSelected(this)">
                        </td>
                        <td class="whitespace-nowrap w-24">
                            <div class="flex justify-center gap-1 items-center px-2">
                                <a class="cursor-pointer" href="./registerRates.php?form=update&id=<?php echo $rate['id'] ?>">
                                    <i class="material-icons text-blue-500 hover:text-blue-700">create</i>
                                </a>
                                <a class="cursor-pointer" type="submit" onclick="confirmDeletion(this)" data-id="<?php echo $rate['id'] ?>">
                                    <i data-id="<?php echo $rate['id'] ?>" class="material-icons text-red-600 hover:text-red-800">delete_forever</i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php }
            } else {
                ?>
                <tr v-else class="transition duration-300 ease-in-out bg-neutral-200">
                    <td colspan="5" class="whitespace-nowrap px-3 py-3 text-center text-red-500 font-bold">
                        <i class="material-icons text-red-500">mood_bad</i>
                        <br />
                        !متاسفانه چیزی برای نمایش در پایگاه داده
                        موجود نیست
                    </td>
                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
</div>
<script>
    let result = null;

    const search = (val) => {
        let pattern = val;
        let superMode = 0;
        const resultBox = document.getElementById("results");

        if (document.getElementById("mode").checked) {
            superMode = 1;
        }

        if (
            (pattern.length > 4 && superMode == 1) ||
            (pattern.length > 6 && superMode == 0)
        ) {
            pattern = pattern.replace(/\s/g, "");
            pattern = pattern.replace(/-/g, "");
            pattern = pattern.replace(/_/g, "");

            resultBox.innerHTML = `<tr class=''>
                <td colspan='14' class='py-10 text-center'> 
                    <img class=' block w-10 mx-auto h-auto' src='./public/img/loading.png' alt='loading'>
                    </td>
            </tr>`;
            var params = new URLSearchParams();
            params.append('pattern', pattern);
            params.append('superMode', superMode);

            axios.post("./app/Controllers/SearchController.php", params)
                .then(function(response) {
                    resultBox.innerHTML = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
            resultBox.innerHTML = "";
        }
    };

    function toggleSelected(e) {
        const element = e;
        const id = element.getAttribute('data-id');
        var params = new URLSearchParams();
        params.append('update_selected_rate', 'update_selected_rate');
        params.append('element_id', id);
        params.append('element_value', element.checked);

        axios.post("./app/Controllers/GoodDeleteController.php", params)
            .then(function(response) {
                console.log(response);
            })
            .catch(function(error) {
                console.log(error);
            });
    }

    function confirmDeletion(e) {
        const element = e;
        const deleteItem = element.getAttribute('data-id');

        var params = new URLSearchParams();
        params.append('delete_id', deleteItem);
        params.append('Delete_rate', 'Delete_rate');

        let text = "آیا مطمئن هستید که میخواهید عملیات حذف را انجام دهید؟";
        if (confirm(text) == true) {
            axios.post("./app/Controllers/GoodDeleteController.php", params)
                .then(function(response) {
                    if (response.data) {
                        location.reload();
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        }

    }
</script>
<?php
require_once('./views/Layouts/footer.php');
