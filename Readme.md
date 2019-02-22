# 个人开发的实用工具
### 一. **仿站工具(phpCraw.php)**
作用：抓取网站页面的前端代码包括图片，js,css文件，实例代码 [https://api.00iy.com/phpCraw.php](https://api.00iy.com/phpCraw.php)<br/>
1. 可设置图片，js,css存储目录
2. 可匹配抓取背景图片，base64编码图片
3. 可设置是否下载网络图片
    
### 二. **生成基础style.css工具(createCss.php)**
作用：生成前端基本的边距，颜色等类 ，实例代码 [https://api.00iy.com/createCss.php](https://api.00iy.com/createCss.php)<br/>

1. 根据pc,web,微信小程序不同场景生成文件
2. 可设置是否压缩
3. 直接下载到本地，一步到位
4. 生成好的文件放在 demoCode目录

### 三. **空格间隔插件(jquery_spaceme.js)**
作用：文本输入框按下空格或,则输入内空自动显示成区块，增加用户体验<br>
依赖：jquery 1.7以上版本<br>，
使用：按下空格或,自动间隔，取值格式为 string,string,string,后期版本可自定义<br>

示意代码：
```css
<style>
.zane-spaceme{position: relative}
.zane-spaceme-choices{overflow:hidden;list-style:none;z-index: 10;padding: 0}
.zane-spaceme-choices .search-choice{float:left;position:relative;position: relative;padding: 2px 16px;margin-right: 10px;background-color:#009688;color: #fff;margin-bottom: 10px;    border-radius: 10px;}
.zane-spaceme-choices .search-choice-close{position: absolute;color: #f13d3d;top: -6px;right: 0px;font-weight: bold}
.zane-spaceme-choices .search-field{float:left}
.zane-spaceme-choices .search-field input {width: 70px;margin-bottom: 10px;}
.normal .search-choice{background-color:#1E9FFF;color: #fff;}
.warm .search-choice{background-color:#FFB800;color: #fff;}
.danger .search-choice{background-color:#FF5722;color: #fff;}
.danger .zane-spaceme-choices .search-choice-close{color: #666;} 
</style>
```
```javascript
<script>
$(function(){  
    $("form input[name=tags]").spaceme({
		id:'spaceme', //添加唯一标识方便重写样式，可空
		skin:'warm' // 默认留空，可选 'normal','warm','danger'
	});
})
</script>
```
