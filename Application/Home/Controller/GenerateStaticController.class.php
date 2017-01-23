<?php
/**
 * 生成静态的项目，位于根目录Public/statics/project_id/
 * 方便把文档导出到git pages, /statics/index.html 会自动生成简单的目录页面
*/

namespace Home\Controller;


class GenerateStaticController extends BaseController
{
    public function index()
    {
        $root_dir = 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/index.php', '/Public/statics/',  $_SERVER['DOCUMENT_URI']);
        $item_id = I("item_id/d");
        $item = D("Item")->where("item_id = '$item_id' ")->find();
        if (empty($item)) {
            return $this->error('项目不存在');
        }
        $dir = "./Public/statics/{$item_id}/";
        $this->clearDir($dir);
        $this->generateMainPage($dir, $item);
        $this->generateMenuList($item_id, $dir, $item);
        $this->success('生成成功', $root_dir);
    }

    private function clearDir($dir)
    {
        if (is_dir($dir)) {
            $open_dir = dir($dir);
            while (false != ($item = $open_dir->read())) {
                if ($item == "." || $item == "..") {
                    continue;
                }
                if (is_dir($open_dir->path . '/' . $item)) {
                    $this->clearDir($open_dir->path . '/' . $item);
                    rmdir($open_dir->path . '/' . $item);
                } else {
                    unlink($open_dir->path . '/' . $item);
                }
            }
            closedir($open_dir);
        }
    }

    private function generateMenuList($item_id, $dir, $item)
    {
        import("Vendor.Parsedown.Parsedown");

        //获取所有父目录id为0的页面
        $pages = D("Page")->where("cat_id = '0' and item_id = '$item_id' ")->order(" `s_number` asc  ")->select();
        $this->generatePages($dir, $pages);
        //获取所有二级目录
        $catalogs = D("Catalog")->where("item_id = '$item_id' and level = 2  ")->order(" `s_number` asc  ")->select();
        if ($catalogs) {
            foreach ($catalogs as $key => &$catalog) {
                //该二级目录下的所有子页面
                $temp = D("Page")->where("cat_id = '$catalog[cat_id]' ")->order(" `s_number` asc  ")->select();
                $catalog['pages'] = $temp ? $temp: array();
                $this->generatePages($dir, $catalog['pages']);

                //该二级目录下的所有子目录
                $temp = D("catalog")->where("parent_cat_id = '$catalog[cat_id]' ")->order(" `s_number` asc  ")->select();
                $catalog['catalogs'] = $temp ? $temp: array();
                if($catalog['catalogs']){
                    //获取所有三级目录的子页面
                    foreach ($catalog['catalogs'] as $key3 => &$catalog3) {
                        //该二级目录下的所有子页面
                        $temp = D("Page")->where("cat_id = '$catalog3[cat_id]' ")->order(" `s_number` asc  ")->select();
                        $catalog3['pages'] = $temp ? $temp: array();
                        $this->generatePages($dir, $catalog3['pages']);
                    }
                }
            }
        }

        $this->assign("catalogs" , $catalogs);
        $this->assign("pages" , $pages);
        $this->assign("item" , $item);
        return $this->buildHtml("index.html", $dir, "StaticsTemplate/menu");
    }

    private function generateMainPage($dir, $item)
    {
        $page_file = realpath('./') . '/Public/statics/page.json';
        $datas = file_get_contents($page_file);
        if (empty($datas)) {
            $datas = array();
        } else {
            $datas = json_decode($datas, true);
        }
        $orders = array();
        foreach ($datas as $key => $data) {
            if ($data['item_id'] == $item['item_id']) {
                unset($datas[$key]);
                continue;
            }
            $orders[] = $data['add_time'];
        }
        $orders[] = $item['addtime'];
        $add_data = array('item_name' => $item['item_name'], 'item_id' => $item['item_id'], 'created_time' => date('Y-m-d', $item['addtime']), 'add_time' => $item['addtime']);
        $datas[] = $add_data;
        array_multisort($orders, SORT_DESC, $datas);
        $ss = file_put_contents($page_file, json_encode($datas));
        if ($ss === false) {
            $this->error('请检查' . $page_file . '目录权限');
        }
    }

    private function generatePages($dir, $pages)
    {
        if (empty($pages)) {
            return false;
        }
        foreach ($pages as $page) {
            $page_id = $page['page_id'];
            $page = D("Page")->where(" page_id = '$page_id' ")->find();
            $Parsedown = new \Parsedown();
            $page['page_content'] = $Parsedown->text(htmlspecialchars_decode($page['page_content']));
            $this->assign("page" , $page);
            $this->buildHtml("{$page_id}.html", $dir."pages/", "StaticsTemplate/page");
        }
    }
}