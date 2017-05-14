<?php
define('PS_SEARCH_MAX_WORD_LENGTH', 15);

/* Copied from Drupal search module, except for \x{0}-\x{2f} that has been replaced by \x{0}-\x{2c}\x{2e}-\x{2f} in order to keep the char '-' */
define('PREG_CLASS_SEARCH_EXCLUDE',
'\x{0}-\x{2c}\x{2e}-\x{2f}\x{3a}-\x{40}\x{5b}-\x{60}\x{7b}-\x{bf}\x{d7}\x{f7}\x{2b0}-'.
'\x{385}\x{387}\x{3f6}\x{482}-\x{489}\x{559}-\x{55f}\x{589}-\x{5c7}\x{5f3}-'.
'\x{61f}\x{640}\x{64b}-\x{65e}\x{66a}-\x{66d}\x{670}\x{6d4}\x{6d6}-\x{6ed}'.
'\x{6fd}\x{6fe}\x{700}-\x{70f}\x{711}\x{730}-\x{74a}\x{7a6}-\x{7b0}\x{901}-'.
'\x{903}\x{93c}\x{93e}-\x{94d}\x{951}-\x{954}\x{962}-\x{965}\x{970}\x{981}-'.
'\x{983}\x{9bc}\x{9be}-\x{9cd}\x{9d7}\x{9e2}\x{9e3}\x{9f2}-\x{a03}\x{a3c}-'.
'\x{a4d}\x{a70}\x{a71}\x{a81}-\x{a83}\x{abc}\x{abe}-\x{acd}\x{ae2}\x{ae3}'.
'\x{af1}-\x{b03}\x{b3c}\x{b3e}-\x{b57}\x{b70}\x{b82}\x{bbe}-\x{bd7}\x{bf0}-'.
'\x{c03}\x{c3e}-\x{c56}\x{c82}\x{c83}\x{cbc}\x{cbe}-\x{cd6}\x{d02}\x{d03}'.
'\x{d3e}-\x{d57}\x{d82}\x{d83}\x{dca}-\x{df4}\x{e31}\x{e34}-\x{e3f}\x{e46}-'.
'\x{e4f}\x{e5a}\x{e5b}\x{eb1}\x{eb4}-\x{ebc}\x{ec6}-\x{ecd}\x{f01}-\x{f1f}'.
'\x{f2a}-\x{f3f}\x{f71}-\x{f87}\x{f90}-\x{fd1}\x{102c}-\x{1039}\x{104a}-'.
'\x{104f}\x{1056}-\x{1059}\x{10fb}\x{10fc}\x{135f}-\x{137c}\x{1390}-\x{1399}'.
'\x{166d}\x{166e}\x{1680}\x{169b}\x{169c}\x{16eb}-\x{16f0}\x{1712}-\x{1714}'.
'\x{1732}-\x{1736}\x{1752}\x{1753}\x{1772}\x{1773}\x{17b4}-\x{17db}\x{17dd}'.
'\x{17f0}-\x{180e}\x{1843}\x{18a9}\x{1920}-\x{1945}\x{19b0}-\x{19c0}\x{19c8}'.
'\x{19c9}\x{19de}-\x{19ff}\x{1a17}-\x{1a1f}\x{1d2c}-\x{1d61}\x{1d78}\x{1d9b}-'.
'\x{1dc3}\x{1fbd}\x{1fbf}-\x{1fc1}\x{1fcd}-\x{1fcf}\x{1fdd}-\x{1fdf}\x{1fed}-'.
'\x{1fef}\x{1ffd}-\x{2070}\x{2074}-\x{207e}\x{2080}-\x{2101}\x{2103}-\x{2106}'.
'\x{2108}\x{2109}\x{2114}\x{2116}-\x{2118}\x{211e}-\x{2123}\x{2125}\x{2127}'.
'\x{2129}\x{212e}\x{2132}\x{213a}\x{213b}\x{2140}-\x{2144}\x{214a}-\x{2b13}'.
'\x{2ce5}-\x{2cff}\x{2d6f}\x{2e00}-\x{3005}\x{3007}-\x{303b}\x{303d}-\x{303f}'.
'\x{3099}-\x{309e}\x{30a0}\x{30fb}\x{30fd}\x{30fe}\x{3190}-\x{319f}\x{31c0}-'.
'\x{31cf}\x{3200}-\x{33ff}\x{4dc0}-\x{4dff}\x{a015}\x{a490}-\x{a716}\x{a802}'.
'\x{e000}-\x{f8ff}\x{fb29}\x{fd3e}-\x{fd3f}\x{fdfc}-\x{fdfd}'.
'\x{fd3f}\x{fdfc}-\x{fe6b}\x{feff}-\x{ff0f}\x{ff1a}-\x{ff20}\x{ff3b}-\x{ff40}'.
'\x{ff5b}-\x{ff65}\x{ff70}\x{ff9e}\x{ff9f}\x{ffe0}-\x{fffd}');

define('PREG_CLASS_NUMBERS',
'\x{30}-\x{39}\x{b2}\x{b3}\x{b9}\x{bc}-\x{be}\x{660}-\x{669}\x{6f0}-\x{6f9}'.
'\x{966}-\x{96f}\x{9e6}-\x{9ef}\x{9f4}-\x{9f9}\x{a66}-\x{a6f}\x{ae6}-\x{aef}'.
'\x{b66}-\x{b6f}\x{be7}-\x{bf2}\x{c66}-\x{c6f}\x{ce6}-\x{cef}\x{d66}-\x{d6f}'.
'\x{e50}-\x{e59}\x{ed0}-\x{ed9}\x{f20}-\x{f33}\x{1040}-\x{1049}\x{1369}-'.
'\x{137c}\x{16ee}-\x{16f0}\x{17e0}-\x{17e9}\x{17f0}-\x{17f9}\x{1810}-\x{1819}'.
'\x{1946}-\x{194f}\x{2070}\x{2074}-\x{2079}\x{2080}-\x{2089}\x{2153}-\x{2183}'.
'\x{2460}-\x{249b}\x{24ea}-\x{24ff}\x{2776}-\x{2793}\x{3007}\x{3021}-\x{3029}'.
'\x{3038}-\x{303a}\x{3192}-\x{3195}\x{3220}-\x{3229}\x{3251}-\x{325f}\x{3280}-'.
'\x{3289}\x{32b1}-\x{32bf}\x{ff10}-\x{ff19}');

define('PREG_CLASS_PUNCTUATION',
'\x{21}-\x{23}\x{25}-\x{2a}\x{2c}-\x{2f}\x{3a}\x{3b}\x{3f}\x{40}\x{5b}-\x{5d}'.
'\x{5f}\x{7b}\x{7d}\x{a1}\x{ab}\x{b7}\x{bb}\x{bf}\x{37e}\x{387}\x{55a}-\x{55f}'.
'\x{589}\x{58a}\x{5be}\x{5c0}\x{5c3}\x{5f3}\x{5f4}\x{60c}\x{60d}\x{61b}\x{61f}'.
'\x{66a}-\x{66d}\x{6d4}\x{700}-\x{70d}\x{964}\x{965}\x{970}\x{df4}\x{e4f}'.
'\x{e5a}\x{e5b}\x{f04}-\x{f12}\x{f3a}-\x{f3d}\x{f85}\x{104a}-\x{104f}\x{10fb}'.
'\x{1361}-\x{1368}\x{166d}\x{166e}\x{169b}\x{169c}\x{16eb}-\x{16ed}\x{1735}'.
'\x{1736}\x{17d4}-\x{17d6}\x{17d8}-\x{17da}\x{1800}-\x{180a}\x{1944}\x{1945}'.
'\x{2010}-\x{2027}\x{2030}-\x{2043}\x{2045}-\x{2051}\x{2053}\x{2054}\x{2057}'.
'\x{207d}\x{207e}\x{208d}\x{208e}\x{2329}\x{232a}\x{23b4}-\x{23b6}\x{2768}-'.
'\x{2775}\x{27e6}-\x{27eb}\x{2983}-\x{2998}\x{29d8}-\x{29db}\x{29fc}\x{29fd}'.
'\x{3001}-\x{3003}\x{3008}-\x{3011}\x{3014}-\x{301f}\x{3030}\x{303d}\x{30a0}'.
'\x{30fb}\x{fd3e}\x{fd3f}\x{fe30}-\x{fe52}\x{fe54}-\x{fe61}\x{fe63}\x{fe68}'.
'\x{fe6a}\x{fe6b}\x{ff01}-\x{ff03}\x{ff05}-\x{ff0a}\x{ff0c}-\x{ff0f}\x{ff1a}'.
'\x{ff1b}\x{ff1f}\x{ff20}\x{ff3b}-\x{ff3d}\x{ff3f}\x{ff5b}\x{ff5d}\x{ff5f}-'.
'\x{ff65}');

/**
 * Matches all CJK characters that are candidates for auto-splitting
 * (Chinese, Japanese, Korean).
 * Contains kana and BMP ideographs.
 */
define('PREG_CLASS_CJK', '\x{3041}-\x{30ff}\x{31f0}-\x{31ff}\x{3400}-\x{4db5}\x{4e00}-\x{9fbb}\x{f900}-\x{fad9}');

/**
 * This is the model class for table "ps_product".
 *
 * The followings are the available columns in table 'ps_product':
 * @property string $id_product
 * @property string $id_supplier
 * @property string $id_manufacturer
 * @property string $id_category_default
 * @property string $id_shop_default
 * @property string $id_tax_rules_group
 * @property integer $on_sale
 * @property integer $online_only
 * @property string $ean13
 * @property string $upc
 * @property string $ecotax
 * @property integer $quantity
 * @property string $minimal_quantity
 * @property string $price
 * @property string $wholesale_price
 * @property string $unity
 * @property string $unit_price_ratio
 * @property string $additional_shipping_cost
 * @property string $reference
 * @property string $supplier_reference
 * @property string $location
 * @property string $width
 * @property string $height
 * @property string $depth
 * @property string $weight
 * @property string $out_of_stock
 * @property integer $quantity_discount
 * @property integer $customizable
 * @property integer $uploadable_files
 * @property integer $text_fields
 * @property integer $active
 * @property string $redirect_type
 * @property string $id_product_redirected
 * @property integer $available_for_order
 * @property string $available_date
 * @property string $condition
 * @property integer $show_price
 * @property integer $indexed
 * @property string $visibility
 * @property integer $cache_is_pack
 * @property integer $cache_has_attachments
 * @property integer $is_virtual
 * @property string $cache_default_attribute
 * @property string $date_add
 * @property string $date_upd
 * @property integer $advanced_stock_management
 * @property string $pack_stock_type
 */
class PsProduct extends CActiveRecord
{
	public $nombre_producto;
	public $cantidadPr= 1;


	function replaceAccentedChars($str)
    {
        /* One source among others:
            http://www.tachyonsoft.com/uc0000.htm
            http://www.tachyonsoft.com/uc0001.htm
            http://www.tachyonsoft.com/uc0004.htm
        */
        $patterns = array(

            /* Lowercase */
            /* a  */ '/[\x{00E0}\x{00E1}\x{00E2}\x{00E3}\x{00E4}\x{00E5}\x{0101}\x{0103}\x{0105}\x{0430}\x{00C0}-\x{00C3}\x{1EA0}-\x{1EB7}]/u',
            /* b  */ '/[\x{0431}]/u',
            /* c  */ '/[\x{00E7}\x{0107}\x{0109}\x{010D}\x{0446}]/u',
            /* d  */ '/[\x{010F}\x{0111}\x{0434}\x{0110}]/u',
            /* e  */ '/[\x{00E8}\x{00E9}\x{00EA}\x{00EB}\x{0113}\x{0115}\x{0117}\x{0119}\x{011B}\x{0435}\x{044D}\x{00C8}-\x{00CA}\x{1EB8}-\x{1EC7}]/u',
            /* f  */ '/[\x{0444}]/u',
            /* g  */ '/[\x{011F}\x{0121}\x{0123}\x{0433}\x{0491}]/u',
            /* h  */ '/[\x{0125}\x{0127}]/u',
            /* i  */ '/[\x{00EC}\x{00ED}\x{00EE}\x{00EF}\x{0129}\x{012B}\x{012D}\x{012F}\x{0131}\x{0438}\x{0456}\x{00CC}\x{00CD}\x{1EC8}-\x{1ECB}\x{0128}]/u',
            /* j  */ '/[\x{0135}\x{0439}]/u',
            /* k  */ '/[\x{0137}\x{0138}\x{043A}]/u',
            /* l  */ '/[\x{013A}\x{013C}\x{013E}\x{0140}\x{0142}\x{043B}]/u',
            /* m  */ '/[\x{043C}]/u',
            /* n  */ '/[\x{00F1}\x{0144}\x{0146}\x{0148}\x{0149}\x{014B}\x{043D}]/u',
            /* o  */ '/[\x{00F2}\x{00F3}\x{00F4}\x{00F5}\x{00F6}\x{00F8}\x{014D}\x{014F}\x{0151}\x{043E}\x{00D2}-\x{00D5}\x{01A0}\x{01A1}\x{1ECC}-\x{1EE3}]/u',
            /* p  */ '/[\x{043F}]/u',
            /* r  */ '/[\x{0155}\x{0157}\x{0159}\x{0440}]/u',
            /* s  */ '/[\x{015B}\x{015D}\x{015F}\x{0161}\x{0441}]/u',
            /* ss */ '/[\x{00DF}]/u',
            /* t  */ '/[\x{0163}\x{0165}\x{0167}\x{0442}]/u',
            /* u  */ '/[\x{00F9}\x{00FA}\x{00FB}\x{00FC}\x{0169}\x{016B}\x{016D}\x{016F}\x{0171}\x{0173}\x{0443}\x{00D9}-\x{00DA}\x{0168}\x{01AF}\x{01B0}\x{1EE4}-\x{1EF1}]/u',
            /* v  */ '/[\x{0432}]/u',
            /* w  */ '/[\x{0175}]/u',
            /* y  */ '/[\x{00FF}\x{0177}\x{00FD}\x{044B}\x{1EF2}-\x{1EF9}\x{00DD}]/u',
            /* z  */ '/[\x{017A}\x{017C}\x{017E}\x{0437}]/u',
            /* ae */ '/[\x{00E6}]/u',
            /* ch */ '/[\x{0447}]/u',
            /* kh */ '/[\x{0445}]/u',
            /* oe */ '/[\x{0153}]/u',
            /* sh */ '/[\x{0448}]/u',
            /* shh*/ '/[\x{0449}]/u',
            /* ya */ '/[\x{044F}]/u',
            /* ye */ '/[\x{0454}]/u',
            /* yi */ '/[\x{0457}]/u',
            /* yo */ '/[\x{0451}]/u',
            /* yu */ '/[\x{044E}]/u',
            /* zh */ '/[\x{0436}]/u',

            /* Uppercase */
            /* A  */ '/[\x{0100}\x{0102}\x{0104}\x{00C0}\x{00C1}\x{00C2}\x{00C3}\x{00C4}\x{00C5}\x{0410}]/u',
            /* B  */ '/[\x{0411}]/u',
            /* C  */ '/[\x{00C7}\x{0106}\x{0108}\x{010A}\x{010C}\x{0426}]/u',
            /* D  */ '/[\x{010E}\x{0110}\x{0414}]/u',
            /* E  */ '/[\x{00C8}\x{00C9}\x{00CA}\x{00CB}\x{0112}\x{0114}\x{0116}\x{0118}\x{011A}\x{0415}\x{042D}]/u',
            /* F  */ '/[\x{0424}]/u',
            /* G  */ '/[\x{011C}\x{011E}\x{0120}\x{0122}\x{0413}\x{0490}]/u',
            /* H  */ '/[\x{0124}\x{0126}]/u',
            /* I  */ '/[\x{0128}\x{012A}\x{012C}\x{012E}\x{0130}\x{0418}\x{0406}]/u',
            /* J  */ '/[\x{0134}\x{0419}]/u',
            /* K  */ '/[\x{0136}\x{041A}]/u',
            /* L  */ '/[\x{0139}\x{013B}\x{013D}\x{0139}\x{0141}\x{041B}]/u',
            /* M  */ '/[\x{041C}]/u',
            /* N  */ '/[\x{00D1}\x{0143}\x{0145}\x{0147}\x{014A}\x{041D}]/u',
            /* O  */ '/[\x{00D3}\x{014C}\x{014E}\x{0150}\x{041E}]/u',
            /* P  */ '/[\x{041F}]/u',
            /* R  */ '/[\x{0154}\x{0156}\x{0158}\x{0420}]/u',
            /* S  */ '/[\x{015A}\x{015C}\x{015E}\x{0160}\x{0421}]/u',
            /* T  */ '/[\x{0162}\x{0164}\x{0166}\x{0422}]/u',
            /* U  */ '/[\x{00D9}\x{00DA}\x{00DB}\x{00DC}\x{0168}\x{016A}\x{016C}\x{016E}\x{0170}\x{0172}\x{0423}]/u',
            /* V  */ '/[\x{0412}]/u',
            /* W  */ '/[\x{0174}]/u',
            /* Y  */ '/[\x{0176}\x{042B}]/u',
            /* Z  */ '/[\x{0179}\x{017B}\x{017D}\x{0417}]/u',
            /* AE */ '/[\x{00C6}]/u',
            /* CH */ '/[\x{0427}]/u',
            /* KH */ '/[\x{0425}]/u',
            /* OE */ '/[\x{0152}]/u',
            /* SH */ '/[\x{0428}]/u',
            /* SHH*/ '/[\x{0429}]/u',
            /* YA */ '/[\x{042F}]/u',
            /* YE */ '/[\x{0404}]/u',
            /* YI */ '/[\x{0407}]/u',
            /* YO */ '/[\x{0401}]/u',
            /* YU */ '/[\x{042E}]/u',
            /* ZH */ '/[\x{0416}]/u');

            // ö to oe
            // å to aa
            // ä to ae

        $replacements = array(
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 'ss', 't', 'u', 'v', 'w', 'y', 'z', 'ae', 'ch', 'kh', 'oe', 'sh', 'shh', 'ya', 'ye', 'yi', 'yo', 'yu', 'zh',
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'V', 'W', 'Y', 'Z', 'AE', 'CH', 'KH', 'OE', 'SH', 'SHH', 'YA', 'YE', 'YI', 'YO', 'YU', 'ZH'
            );

        return preg_replace($patterns, $replacements, $str);
    }
	function sanitize($string, $id_lang, $indexation = false, $iso_code = false)
    {
       $string = trim($string);
        if (empty($string)) {
            return '';
        }

        $string = strtolower(strip_tags($string));
        $string = html_entity_decode($string, ENT_NOQUOTES, 'utf-8');

        $string = preg_replace('/(['.PREG_CLASS_NUMBERS.']+)['.PREG_CLASS_PUNCTUATION.']+(?=['.PREG_CLASS_NUMBERS.'])/u', '\1', $string);
        $string = preg_replace('/['.PREG_CLASS_SEARCH_EXCLUDE.']+/u', ' ', $string);

        if ($indexation) {
            $string = preg_replace('/[._-]+/', ' ', $string);
        } else {
            $words = explode(' ', $string);
            $processed_words = array();
            // search for aliases for each word of the query
            foreach ($words as $word) {
                $processed_words[] = $word;
            }
            $string = implode(' ', $processed_words);
            $string = preg_replace('/[._]+/', '', $string);
            $string = ltrim(preg_replace('/([^ ])-/', '$1 ', ' '.$string));
            $string = preg_replace('/[._]+/', '', $string);
            $string = preg_replace('/[^\s]-+/', '', $string);
        }

        $string = $this->replaceAccentedChars(trim(preg_replace('/\s+/', ' ', $string)));
            
        return $string;
    }

	public function getImageProd()
    {
		$psImagen = Yii::app()->db->createCommand()->select('id_image')->from('ps_image')
			->where('id_product=:id_product', array(':id_product'=> $this->id_product))
			->queryRow();
		$arrayFolder= str_split($psImagen['id_image']);
		$folders= implode('/', $arrayFolder);
		$foldersImage= 'http://nsstore.mx/e-commerce/img/p/'.$folders.'/'.$psImagen['id_image'].'-small_default.jpg';
	   	return CHtml::image($foldersImage, 'Imagen de Producto');  
	} 
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ps_product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tax_rules_group, date_add, date_upd', 'required'),
			array('on_sale, online_only, quantity, quantity_discount, customizable, uploadable_files, text_fields, active, available_for_order, show_price, indexed, cache_is_pack, cache_has_attachments, is_virtual, advanced_stock_management', 'numerical', 'integerOnly'=>true),
			array('id_supplier, id_manufacturer, id_category_default, id_shop_default, minimal_quantity, out_of_stock, id_product_redirected, cache_default_attribute', 'length', 'max'=>10),
			array('id_tax_rules_group, condition, pack_stock_type', 'length', 'max'=>11),
			array('ean13', 'length', 'max'=>13),
			array('upc', 'length', 'max'=>12),
			array('ecotax', 'length', 'max'=>17),
			array('price, wholesale_price, unit_price_ratio, additional_shipping_cost, width, height, depth, weight', 'length', 'max'=>20),
			array('unity', 'length', 'max'=>255),
			array('reference, supplier_reference', 'length', 'max'=>32),
			array('location', 'length', 'max'=>64),
			array('redirect_type', 'length', 'max'=>3),
			array('visibility', 'length', 'max'=>7),
			array('available_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_product, id_supplier, id_manufacturer, id_category_default, id_shop_default, id_tax_rules_group, on_sale, online_only, ean13, upc, ecotax, quantity, minimal_quantity, price, wholesale_price, unity, unit_price_ratio, additional_shipping_cost, reference, supplier_reference, location, width, height, depth, weight, out_of_stock, quantity_discount, customizable, uploadable_files, text_fields, active, redirect_type, id_product_redirected, available_for_order, available_date, condition, show_price, indexed, visibility, cache_is_pack, cache_has_attachments, is_virtual, cache_default_attribute, date_add, date_upd, advanced_stock_management, pack_stock_type, nombre_producto, precio_lista, precio_mm, precio_mayoreo, selected_price', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'lang' => array(self::HAS_ONE, 'PsProductLang', 'id_product', 'condition'=>'id_lang=1'),
			'cotizacionTmp' => array(self::HAS_MANY, 'CotCotizaciontmp', 'id_product'),
            'producto'=>array(self::HAS_ONE, 'PsStockAvailable', 'id_product'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_product' => 'Id Product',
			'id_supplier' => 'Id Supplier',
			'id_manufacturer' => 'Id Manufacturer',
			'id_category_default' => 'Id Category Default',
			'id_shop_default' => 'Id Shop Default',
			'id_tax_rules_group' => 'Id Tax Rules Group',
			'on_sale' => 'On Sale',
			'online_only' => 'Online Only',
			'ean13' => 'Ean13',
			'upc' => 'Upc',
			'ecotax' => 'Ecotax',
			'quantity' => 'Cantidad',
			'minimal_quantity' => 'Minimal Quantity',
			'price' => 'Precio',
			'wholesale_price' => 'Wholesale Price',
			'unity' => 'Unity',
			'unit_price_ratio' => 'Unit Price Ratio',
			'additional_shipping_cost' => 'Additional Shipping Cost',
			'reference' => 'Clave Producto',
			'supplier_reference' => 'Supplier Reference',
			'location' => 'Location',
			'width' => 'Width',
			'height' => 'Height',
			'depth' => 'Depth',
			'weight' => 'Weight',
			'out_of_stock' => 'Out Of Stock',
			'quantity_discount' => 'Quantity Discount',
			'customizable' => 'Customizable',
			'uploadable_files' => 'Uploadable Files',
			'text_fields' => 'Text Fields',
			'active' => 'Active',
			'redirect_type' => 'Redirect Type',
			'id_product_redirected' => 'Id Product Redirected',
			'available_for_order' => 'Available For Order',
			'available_date' => 'Available Date',
			'condition' => 'Condition',
			'show_price' => 'Show Price',
			'indexed' => 'Indexed',
			'visibility' => 'Visibility',
			'cache_is_pack' => 'Cache Is Pack',
			'cache_has_attachments' => 'Cache Has Attachments',
			'is_virtual' => 'Is Virtual',
			'cache_default_attribute' => 'Cache Default Attribute',
			'date_add' => 'Date Add',
			'date_upd' => 'Date Upd',
			'advanced_stock_management' => 'Advanced Stock Management',
			'pack_stock_type' => 'Pack Stock Type',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		//Busca palabras sin un orden específico (Búsqueda sensible)
		if($_GET['PsProduct']['nombre_producto']!= '')
		{
			//$palabrasBusqueda= explode(' ', $_GET['PsProduct']['nombre_producto']);
			/*man*/
			$palabrasBusqueda = explode(' ', $this->sanitize($_GET['PsProduct']['nombre_producto'], 1, false, 'es'));
			/*man*/
			$todosProductos = Yii::app()->db->createCommand()
                ->select('id_product')->from('ps_product')->where('active = :ac', array(':ac'=> 1))
                ->queryAll();
            foreach ($todosProductos as $producto) {
            	$eligible_products[]= $producto['id_product'];
            }

			foreach ($palabrasBusqueda as $key => $value) {
				$consulta= "SELECT si.id_product
					FROM ps_search_word sw
					LEFT JOIN ps_search_index si ON sw.id_word = si.id_word
					WHERE sw.id_lang = 1
						AND sw.id_shop = 1
						AND sw.word LIKE '".$value."%'";

				$intersect_array[]= $consulta;	
			}

			foreach ($intersect_array as $query) {
	            $eligible_products2 = array();
	            $queries= Yii::app()->db->createCommand($query)->queryAll();
	            foreach ($queries as $row) {
	                $eligible_products2[] = $row['id_product'];
	            }
	            
	            $eligible_products = array_intersect($eligible_products, $eligible_products2);
	        }

	        $eligible_products = array_unique($eligible_products);
		}
		
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		//$criteria->with=array('lang');
		//$criteria->compare('lang.name', $this->nombre_producto, true);
		//$criteria->compare('t.id_product',$this->id_product,true);
		$criteria->compare('t.quantity',$this->quantity);
		$criteria->compare('t.price',$this->price,true);
		$criteria->compare('t.reference',$this->reference,true);
		$criteria->compare('t.active',$this->active);
		$criteria->compare('t.precio_lista',$this->precio_lista);
		$criteria->compare('t.precio_mm',$this->precio_mm);
		$criteria->compare('t.precio_mayoreo',$this->precio_mayoreo);
        $criteria->compare('producto.quantity',$this->id_product,true);
		//$criteria->addSearchCondition('lang.name', $_GET['PsProduct']['nombre_producto']);
		$criteria->addCondition('t.active= 1');
		if($_GET['PsProduct']['nombre_producto']!= '')
			$criteria->addInCondition('t.id_product', $eligible_products);

		Yii::app()->session['criteriaSession'] = $criteria;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'pagination'=> array('pageSize'=>6)
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PsProduct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
