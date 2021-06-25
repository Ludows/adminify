/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/name2mime/lib/index.js":
/*!*********************************************!*\
  !*** ./node_modules/name2mime/lib/index.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
Object.defineProperty(exports,'__esModule',{value:!0});var types=__webpack_require__(/*! ./types.json */ "./node_modules/name2mime/lib/types.json"),getMime=function(a){var b=types[a.substr(a.lastIndexOf('.'))];return b||{type:'binary/octet-stream',name:'Default'}};exports.default=getMime,module.exports=exports.default;

/***/ }),

/***/ "./node_modules/name2mime/lib/types.json":
/*!***********************************************!*\
  !*** ./node_modules/name2mime/lib/types.json ***!
  \***********************************************/
/*! exports provided: .x3d, .3gp, .3g2, .mseq, .pwn, .plb, .psb, .pvb, .tcap, .7z, .abw, .ace, .acc, .acu, .atc, .adp, .aab, .aam, .aas, .air, .swf, .fxp, .pdf, .ppd, .dir, .xdp, .xfdf, .aac, .ahead, .azf, .azs, .azw, .ami, N/A, .apk, .cii, .fti, .atx, .dmg, .mpkg, .aw, .les, .swi, .s, .atomcat, .atomsvc, .atom, .xml, .ac, .aif, .avi, .aep, .dxf, .dwf, .par, .bcpio, .bin, .bmp, .torrent, .cod, .mpm, .bmi, .sh, .btif, .rep, .bz, .bz2, .csh, .c, .cdxml, .css, .cdx, .cml, .csml, .cdbcmsg, .cla, .c4g, .sub, .cdmia, .cdmic, .cdmid, .cdmio, .cdmiq, .c11amc, .c11amz, .ras, .dae, .csv, .cpt, .wmlc, .cgm, .ice, .cmx, .xar, .cmc, .cpio, .clkx, .clkk, .clkp, .clkt, .clkw, .wbs, .cryptonote, .cif, .cmdf, .cu, .cww, .curl, .dcurl, .mcurl, .scurl, .car, .pcurl, .cmp, .dssc, .xdssc, .deb, .uva, .uvi, .uvh, .uvm, .uvu, .uvp, .uvs, .uvv, .dvi, .seed, .dtb, .res, .ait, .svc, .eol, .djvu, .dtd, .mlp, .wad, .dpg, .dra, .dfac, .dts, .dtshd, .dwg, .geo, .es, .mag, .mmr, .rlc, .exi, .mgz, .epub, .eml, .nml, .xpr, .xif, .xfdl, .emma, .ez2, .ez3, .fst, .fvt, .fbs, .fe_launch, .f4v, .flv, .fpx, .npx, .flx, .fli, .ftc, .fdf, .f, .mif, .fm, .fh, .fsc, .fnc, .ltf, .ddd, .xdw, .xbd, .oas, .oa2, .oa3, .fg5, .bh2, .spl, .fzs, .g3, .gmx, .gtw, .txd, .ggb, .ggt, .gdl, .gex, .gxt, .g2w, .g3w, .gsf, .bdf, .gtar, .texinfo, .gnumeric, .kml, .kmz, .gqf, .gif, .gv, .gac, .ghf, .gim, .grv, .gtm, .tpl, .vcg, .h261, .h263, .h264, .hpid, .hps, .hdf, .rip, .hbci, .jlt, .pcl, .hpgl, .hvs, .hvd, .hvp, .sfd-hdstx, .stk, .hal, .html, .irm, .sc, .ics, .icc, .ico, .igl, .ief, .ivp, .ivu, .rif, .3dml, .spot, .igs, .i2g, .cdy, .xpw, .fcs, .ipfix, .cer, .pki, .crl, .pkipath, .igm, .rcprofile, .irp, .jad, .jar, .class, .jnlp, .ser, .java, .js, .json, .joda, .jpm, .jpeg, .jpg, .pjpeg, .jpgv, .ktz, .mmd, .karbon, .chrt, .kfo, .flw, .kon, .kpr, .ksp, .kwd, .htke, .kia, .kne, .sse, .lasxml, .latex, .lbd, .lbe, .jam, .123, .apr, .pre, .nsf, .org, .scm, .lwp, .lvp, .m3u, .m4v, .hqx, .portpkg, .mgp, .mrc, .mrcx, .mxf, .nbp, .ma, .mathml, .mbox, .mc1, .mscml, .cdkey, .mwf, .mfm, .msh, .mads, .mets, .mods, .meta4, .mcd, .flo, .igx, .es3, .mdb, .asf, .exe, .cil, .cab, .ims, .application, .clp, .mdi, .eot, .xls, .xlam, .xlsb, .xltm, .xlsm, .chm, .crd, .lrm, .mvb, .mny, .pptx, .sldx, .ppsx, .potx, .xlsx, .xltx, .docx, .dotx, .obd, .thmx, .onetoc, .pya, .pyv, .ppt, .ppam, .sldm, .pptm, .ppsm, .potm, .mpp, .pub, .scd, .xap, .stl, .cat, .vsd, .vsdx, .wm, .wma, .wax, .wmx, .wmd, .wpl, .wmz, .wmv, .wvx, .wmf, .trm, .doc, .docm, .dotm, .wri, .wps, .xbap, .xps, .mid, .mpy, .afp, .rms, .tmo, .prc, .mbk, .dis, .plc, .mqy, .msl, .txf, .daf, .fly, .mpc, .mpn, .mj2, .mpga, .mxu, .mpeg, .m21, .mp4a, .mp4, .m3u8, .mus, .msty, .mxml, .ngdat, .n-gage, .ncx, .nc, .nlu, .dna, .nnd, .nns, .nnw, .rpst, .rpss, .n3, .edm, .edx, .ext, .gph, .ecelp4800, .ecelp7470, .ecelp9600, .oda, .ogx, .oga, .ogv, .dd2, .oth, .opf, .qbo, .oxt, .osf, .weba, .webm, .odc, .otc, .odb, .odf, .odft, .odg, .otg, .odi, .oti, .odp, .otp, .ods, .ots, .odt, .odm, .ott, .ktx, .sxc, .stc, .sxd, .std, .sxi, .sti, .sxm, .sxw, .sxg, .stw, .otf, .osfpvg, .dp, .pdb, .p, .paw, .pclxl, .efif, .pcx, .psd, .prf, .pic, .chat, .p10, .p12, .p7m, .p7s, .p7r, .p7b, .p8, .plf, .pnm, .pbm, .pcf, .pfr, .pgn, .pgm, .png, .ppm, .pskcxml, .pml, .ai, .pfa, .pbd, .pgp, .box, .ptid, .pls, .str, .ei6, .dsc, .psf, .qps, .wg, .qxd, .esf, .msf, .ssf, .qam, .qfx, .qt, .rar, .ram, .rmp, .rsd, .rm, .bed, .mxl, .musicxml, .rnc, .rdz, .rdf, .rp9, .jisp, .rtf, .rtx, .link66, .rss, .shf, .st, .svg, .sus, .sru, .setpay, .setreg, .sema, .semd, .semf, .see, .snf, .spq, .spp, .scq, .scs, .sdp, .etx, .movie, .ifm, .itp, .iif, .ipk, .tfi, .shar, .rgb, .slt, .aso, .imp, .twd, .csp, .saf, .mmf, .spf, .teacher, .svd, .rq, .srx, .gram, .grxml, .ssml, .skp, .sgml, .sdc, .sda, .sdd, .smf, .sdw, .sgl, .sm, .sit, .sitx, .sdkm, .xo, .au, .wqd, .sis, .smi, .xsm, .bdm, .xdm, .sv4cpio, .sv4crc, .sbml, .tsv, .tiff, .tao, .tar, .tcl, .tex, .tfm, .tei, .txt, .dxp, .sfs, .tsd, .tpt, .mxs, .t, .tra, .ttf, .ttl, .umj, .uoml, .unityweb, .ufd, .uri, .utz, .ustar, .uu, .vcs, .vcf, .vcd, .vsf, .wrl, .vcx, .mts, .vtu, .vis, .viv, .ccxml, .vxml, .src, .wbxml, .wbmp, .wav, .davmount, .woff, .wspolicy, .webp, .wtb, .wgt, .hlp, .wml, .wmls, .wmlsc, .wpd, .stf, .wsdl, .xbm, .xpm, .xwd, .der, .fig, .xhtml, .xdf, .xenc, .xer, .rl, .rs, .rld, .xslt, .xop, .xpi, .xspf, .xul, .xyz, .yaml, .yang, .yin, .zir, .zip, .zmm, .zaz, default */
/***/ (function(module) {

module.exports = JSON.parse("{\".x3d\":{\"type\":\"application/vnd.hzn-3d-crossword\",\"name\":\"3D Crossword Plugin\"},\".3gp\":{\"type\":\"video/3gpp\",\"name\":\"3GP\"},\".3g2\":{\"type\":\"video/3gpp2\",\"name\":\"3GP2\"},\".mseq\":{\"type\":\"application/vnd.mseq\",\"name\":\"3GPP MSEQ File\"},\".pwn\":{\"type\":\"application/vnd.3m.post-it-notes\",\"name\":\"3M Post It Notes\"},\".plb\":{\"type\":\"application/vnd.3gpp.pic-bw-large\",\"name\":\"3rd Generation Partnership Project - Pic Large\"},\".psb\":{\"type\":\"application/vnd.3gpp.pic-bw-small\",\"name\":\"3rd Generation Partnership Project - Pic Small\"},\".pvb\":{\"type\":\"application/vnd.3gpp.pic-bw-var\",\"name\":\"3rd Generation Partnership Project - Pic Var\"},\".tcap\":{\"type\":\"application/vnd.3gpp2.tcap\",\"name\":\"3rd Generation Partnership Project - Transaction Capabilities Application Part\"},\".7z\":{\"type\":\"application/x-7z-compressed\",\"name\":\"7-Zip\"},\".abw\":{\"type\":\"application/x-abiword\",\"name\":\"AbiWord\"},\".ace\":{\"type\":\"application/x-ace-compressed\",\"name\":\"Ace Archive\"},\".acc\":{\"type\":\"application/vnd.americandynamics.acc\",\"name\":\"Active Content Compression\"},\".acu\":{\"type\":\"application/vnd.acucobol\",\"name\":\"ACU Cobol\"},\".atc\":{\"type\":\"application/vnd.acucorp\",\"name\":\"ACU Cobol\"},\".adp\":{\"type\":\"audio/adpcm\",\"name\":\"Adaptive differential pulse-code modulation\"},\".aab\":{\"type\":\"application/x-authorware-bin\",\"name\":\"Adobe (Macropedia) Authorware - Binary File\"},\".aam\":{\"type\":\"application/x-authorware-map\",\"name\":\"Adobe (Macropedia) Authorware - Map\"},\".aas\":{\"type\":\"application/x-authorware-seg\",\"name\":\"Adobe (Macropedia) Authorware - Segment File\"},\".air\":{\"type\":\"application/vnd.adobe.air-application-installer-package+zip\",\"name\":\"Adobe AIR Application\"},\".swf\":{\"type\":\"application/x-shockwave-flash\",\"name\":\"Adobe Flash\"},\".fxp\":{\"type\":\"application/vnd.adobe.fxp\",\"name\":\"Adobe Flex Project\"},\".pdf\":{\"type\":\"application/pdf\",\"name\":\"Adobe Portable Document Format\"},\".ppd\":{\"type\":\"application/vnd.cups-ppd\",\"name\":\"Adobe PostScript Printer Description File Format\"},\".dir\":{\"type\":\"application/x-director\",\"name\":\"Adobe Shockwave Player\"},\".xdp\":{\"type\":\"application/vnd.adobe.xdp+xml\",\"name\":\"Adobe XML Data Package\"},\".xfdf\":{\"type\":\"application/vnd.adobe.xfdf\",\"name\":\"Adobe XML Forms Data Format\"},\".aac\":{\"type\":\"audio/x-aac\",\"name\":\"Advanced Audio Coding (AAC)\"},\".ahead\":{\"type\":\"application/vnd.ahead.space\",\"name\":\"Ahead AIR Application\"},\".azf\":{\"type\":\"application/vnd.airzip.filesecure.azf\",\"name\":\"AirZip FileSECURE\"},\".azs\":{\"type\":\"application/vnd.airzip.filesecure.azs\",\"name\":\"AirZip FileSECURE\"},\".azw\":{\"type\":\"application/vnd.amazon.ebook\",\"name\":\"Amazon Kindle eBook format\"},\".ami\":{\"type\":\"application/vnd.amiga.ami\",\"name\":\"AmigaDE\"},\"N/A\":{\"type\":\"application/andrew-inset\",\"name\":\"Andrew Toolkit\"},\".apk\":{\"type\":\"application/vnd.android.package-archive\",\"name\":\"Android Package Archive\"},\".cii\":{\"type\":\"application/vnd.anser-web-certificate-issue-initiation\",\"name\":\"ANSER-WEB Terminal Client - Certificate Issue\"},\".fti\":{\"type\":\"application/vnd.anser-web-funds-transfer-initiation\",\"name\":\"ANSER-WEB Terminal Client - Web Funds Transfer\"},\".atx\":{\"type\":\"application/vnd.antix.game-component\",\"name\":\"Antix Game Player\"},\".dmg\":{\"type\":\"application/x-apple-diskimage\",\"name\":\"Apple Disk Image\"},\".mpkg\":{\"type\":\"application/vnd.apple.installer+xml\",\"name\":\"Apple Installer Package\"},\".aw\":{\"type\":\"application/applixware\",\"name\":\"Applixware\"},\".les\":{\"type\":\"application/vnd.hhe.lesson-player\",\"name\":\"Archipelago Lesson Player\"},\".swi\":{\"type\":\"application/vnd.aristanetworks.swi\",\"name\":\"Arista Networks Software Image\"},\".s\":{\"type\":\"text/x-asm\",\"name\":\"Assembler Source File\"},\".atomcat\":{\"type\":\"application/atomcat+xml\",\"name\":\"Atom Publishing Protocol\"},\".atomsvc\":{\"type\":\"application/atomsvc+xml\",\"name\":\"Atom Publishing Protocol Service Document\"},\".atom\":{\"type\":\"application/atom+xml\",\"name\":\"Atom Syndication Format\"},\".xml\":{\"type\":\"application/atom+xml\",\"name\":\"Atom Syndication Format\"},\".ac\":{\"type\":\"application/pkix-attr-cert\",\"name\":\"Attribute Certificate\"},\".aif\":{\"type\":\"audio/x-aiff\",\"name\":\"Audio Interchange File Format\"},\".avi\":{\"type\":\"video/x-msvideo\",\"name\":\"Audio Video Interleave (AVI)\"},\".aep\":{\"type\":\"application/vnd.audiograph\",\"name\":\"Audiograph\"},\".dxf\":{\"type\":\"image/vnd.dxf\",\"name\":\"AutoCAD DXF\"},\".dwf\":{\"type\":\"model/vnd.dwf\",\"name\":\"Autodesk Design Web Format (DWF)\"},\".par\":{\"type\":\"text/plain-bas\",\"name\":\"BAS Partitur Format\"},\".bcpio\":{\"type\":\"application/x-bcpio\",\"name\":\"Binary CPIO Archive\"},\".bin\":{\"type\":\"application/octet-stream\",\"name\":\"Binary Data\"},\".bmp\":{\"type\":\"image/bmp\",\"name\":\"Bitmap Image File\"},\".torrent\":{\"type\":\"application/x-bittorrent\",\"name\":\"BitTorrent\"},\".cod\":{\"type\":\"application/vnd.rim.cod\",\"name\":\"Blackberry COD File\"},\".mpm\":{\"type\":\"application/vnd.blueice.multipass\",\"name\":\"Blueice Research Multipass\"},\".bmi\":{\"type\":\"application/vnd.bmi\",\"name\":\"BMI Drawing Data Interchange\"},\".sh\":{\"type\":\"application/x-sh\",\"name\":\"Bourne Shell Script\"},\".btif\":{\"type\":\"image/prs.btif\",\"name\":\"BTIF\"},\".rep\":{\"type\":\"application/vnd.businessobjects\",\"name\":\"BusinessObjects\"},\".bz\":{\"type\":\"application/x-bzip\",\"name\":\"Bzip Archive\"},\".bz2\":{\"type\":\"application/x-bzip2\",\"name\":\"Bzip2 Archive\"},\".csh\":{\"type\":\"application/x-csh\",\"name\":\"C Shell Script\"},\".c\":{\"type\":\"text/x-c\",\"name\":\"C Source File\"},\".cdxml\":{\"type\":\"application/vnd.chemdraw+xml\",\"name\":\"CambridgeSoft Chem Draw\"},\".css\":{\"type\":\"text/css\",\"name\":\"Cascading Style Sheets (CSS)\"},\".cdx\":{\"type\":\"chemical/x-cdx\",\"name\":\"ChemDraw eXchange file\"},\".cml\":{\"type\":\"chemical/x-cml\",\"name\":\"Chemical Markup Language\"},\".csml\":{\"type\":\"chemical/x-csml\",\"name\":\"Chemical Style Markup Language\"},\".cdbcmsg\":{\"type\":\"application/vnd.contact.cmsg\",\"name\":\"CIM Database\"},\".cla\":{\"type\":\"application/vnd.claymore\",\"name\":\"Claymore Data Files\"},\".c4g\":{\"type\":\"application/vnd.clonk.c4group\",\"name\":\"Clonk Game\"},\".sub\":{\"type\":\"image/vnd.dvb.subtitle\",\"name\":\"Close Captioning - Subtitle\"},\".cdmia\":{\"type\":\"application/cdmi-capability\",\"name\":\"Cloud Data Management Interface (CDMI) - Capability\"},\".cdmic\":{\"type\":\"application/cdmi-container\",\"name\":\"Cloud Data Management Interface (CDMI) - Contaimer\"},\".cdmid\":{\"type\":\"application/cdmi-domain\",\"name\":\"Cloud Data Management Interface (CDMI) - Domain\"},\".cdmio\":{\"type\":\"application/cdmi-object\",\"name\":\"Cloud Data Management Interface (CDMI) - Object\"},\".cdmiq\":{\"type\":\"application/cdmi-queue\",\"name\":\"Cloud Data Management Interface (CDMI) - Queue\"},\".c11amc\":{\"type\":\"application/vnd.cluetrust.cartomobile-config\",\"name\":\"ClueTrust CartoMobile - Config\"},\".c11amz\":{\"type\":\"application/vnd.cluetrust.cartomobile-config-pkg\",\"name\":\"ClueTrust CartoMobile - Config Package\"},\".ras\":{\"type\":\"image/x-cmu-raster\",\"name\":\"CMU Image\"},\".dae\":{\"type\":\"model/vnd.collada+xml\",\"name\":\"COLLADA\"},\".csv\":{\"type\":\"text/csv\",\"name\":\"Comma-Seperated Values\"},\".cpt\":{\"type\":\"application/mac-compactpro\",\"name\":\"Compact Pro\"},\".wmlc\":{\"type\":\"application/vnd.wap.wmlc\",\"name\":\"Compiled Wireless Markup Language (WMLC)\"},\".cgm\":{\"type\":\"image/cgm\",\"name\":\"Computer Graphics Metafile\"},\".ice\":{\"type\":\"x-conference/x-cooltalk\",\"name\":\"CoolTalk\"},\".cmx\":{\"type\":\"image/x-cmx\",\"name\":\"Corel Metafile Exchange (CMX)\"},\".xar\":{\"type\":\"application/vnd.xara\",\"name\":\"CorelXARA\"},\".cmc\":{\"type\":\"application/vnd.cosmocaller\",\"name\":\"CosmoCaller\"},\".cpio\":{\"type\":\"application/x-cpio\",\"name\":\"CPIO Archive\"},\".clkx\":{\"type\":\"application/vnd.crick.clicker\",\"name\":\"CrickSoftware - Clicker\"},\".clkk\":{\"type\":\"application/vnd.crick.clicker.keyboard\",\"name\":\"CrickSoftware - Clicker - Keyboard\"},\".clkp\":{\"type\":\"application/vnd.crick.clicker.palette\",\"name\":\"CrickSoftware - Clicker - Palette\"},\".clkt\":{\"type\":\"application/vnd.crick.clicker.template\",\"name\":\"CrickSoftware - Clicker - Template\"},\".clkw\":{\"type\":\"application/vnd.crick.clicker.wordbank\",\"name\":\"CrickSoftware - Clicker - Wordbank\"},\".wbs\":{\"type\":\"application/vnd.criticaltools.wbs+xml\",\"name\":\"Critical Tools - PERT Chart EXPERT\"},\".cryptonote\":{\"type\":\"application/vnd.rig.cryptonote\",\"name\":\"CryptoNote\"},\".cif\":{\"type\":\"chemical/x-cif\",\"name\":\"Crystallographic Interchange Format\"},\".cmdf\":{\"type\":\"chemical/x-cmdf\",\"name\":\"CrystalMaker Data Format\"},\".cu\":{\"type\":\"application/cu-seeme\",\"name\":\"CU-SeeMe\"},\".cww\":{\"type\":\"application/prs.cww\",\"name\":\"CU-Writer\"},\".curl\":{\"type\":\"text/vnd.curl\",\"name\":\"Curl - Applet\"},\".dcurl\":{\"type\":\"text/vnd.curl.dcurl\",\"name\":\"Curl - Detached Applet\"},\".mcurl\":{\"type\":\"text/vnd.curl.mcurl\",\"name\":\"Curl - Manifest File\"},\".scurl\":{\"type\":\"text/vnd.curl.scurl\",\"name\":\"Curl - Source Code\"},\".car\":{\"type\":\"application/vnd.curl.car\",\"name\":\"CURL Applet\"},\".pcurl\":{\"type\":\"application/vnd.curl.pcurl\",\"name\":\"CURL Applet\"},\".cmp\":{\"type\":\"application/vnd.yellowriver-custom-menu\",\"name\":\"CustomMenu\"},\".dssc\":{\"type\":\"application/dssc+der\",\"name\":\"Data Structure for the Security Suitability of Cryptographic Algorithms\"},\".xdssc\":{\"type\":\"application/dssc+xml\",\"name\":\"Data Structure for the Security Suitability of Cryptographic Algorithms\"},\".deb\":{\"type\":\"application/x-debian-package\",\"name\":\"Debian Package\"},\".uva\":{\"type\":\"audio/vnd.dece.audio\",\"name\":\"DECE Audio\"},\".uvi\":{\"type\":\"image/vnd.dece.graphic\",\"name\":\"DECE Graphic\"},\".uvh\":{\"type\":\"video/vnd.dece.hd\",\"name\":\"DECE High Definition Video\"},\".uvm\":{\"type\":\"video/vnd.dece.mobile\",\"name\":\"DECE Mobile Video\"},\".uvu\":{\"type\":\"video/vnd.uvvu.mp4\",\"name\":\"DECE MP4\"},\".uvp\":{\"type\":\"video/vnd.dece.pd\",\"name\":\"DECE PD Video\"},\".uvs\":{\"type\":\"video/vnd.dece.sd\",\"name\":\"DECE SD Video\"},\".uvv\":{\"type\":\"video/vnd.dece.video\",\"name\":\"DECE Video\"},\".dvi\":{\"type\":\"application/x-dvi\",\"name\":\"Device Independent File Format (DVI)\"},\".seed\":{\"type\":\"application/vnd.fdsn.seed\",\"name\":\"Digital Siesmograph Networks - SEED Datafiles\"},\".dtb\":{\"type\":\"application/x-dtbook+xml\",\"name\":\"Digital Talking Book\"},\".res\":{\"type\":\"application/x-dtbresource+xml\",\"name\":\"Digital Talking Book - Resource File\"},\".ait\":{\"type\":\"application/vnd.dvb.ait\",\"name\":\"Digital Video Broadcasting\"},\".svc\":{\"type\":\"application/vnd.dvb.service\",\"name\":\"Digital Video Broadcasting\"},\".eol\":{\"type\":\"audio/vnd.digital-winds\",\"name\":\"Digital Winds Music\"},\".djvu\":{\"type\":\"image/vnd.djvu\",\"name\":\"DjVu\"},\".dtd\":{\"type\":\"application/xml-dtd\",\"name\":\"Document Type Definition\"},\".mlp\":{\"type\":\"application/vnd.dolby.mlp\",\"name\":\"Dolby Meridian Lossless Packing\"},\".wad\":{\"type\":\"application/x-doom\",\"name\":\"Doom Video Game\"},\".dpg\":{\"type\":\"application/vnd.dpgraph\",\"name\":\"DPGraph\"},\".dra\":{\"type\":\"audio/vnd.dra\",\"name\":\"DRA Audio\"},\".dfac\":{\"type\":\"application/vnd.dreamfactory\",\"name\":\"DreamFactory\"},\".dts\":{\"type\":\"audio/vnd.dts\",\"name\":\"DTS Audio\"},\".dtshd\":{\"type\":\"audio/vnd.dts.hd\",\"name\":\"DTS High Definition Audio\"},\".dwg\":{\"type\":\"image/vnd.dwg\",\"name\":\"DWG Drawing\"},\".geo\":{\"type\":\"application/vnd.dynageo\",\"name\":\"DynaGeo\"},\".es\":{\"type\":\"application/ecmascript\",\"name\":\"ECMAScript\"},\".mag\":{\"type\":\"application/vnd.ecowin.chart\",\"name\":\"EcoWin Chart\"},\".mmr\":{\"type\":\"image/vnd.fujixerox.edmics-mmr\",\"name\":\"EDMICS 2000\"},\".rlc\":{\"type\":\"image/vnd.fujixerox.edmics-rlc\",\"name\":\"EDMICS 2000\"},\".exi\":{\"type\":\"application/exi\",\"name\":\"Efficient XML Interchange\"},\".mgz\":{\"type\":\"application/vnd.proteus.magazine\",\"name\":\"EFI Proteus\"},\".epub\":{\"type\":\"application/epub+zip\",\"name\":\"Electronic Publication\"},\".eml\":{\"type\":\"message/rfc822\",\"name\":\"Email Message\"},\".nml\":{\"type\":\"application/vnd.enliven\",\"name\":\"Enliven Viewer\"},\".xpr\":{\"type\":\"application/vnd.is-xpr\",\"name\":\"Express by Infoseek\"},\".xif\":{\"type\":\"image/vnd.xiff\",\"name\":\"eXtended Image File Format (XIFF)\"},\".xfdl\":{\"type\":\"application/vnd.xfdl\",\"name\":\"Extensible Forms Description Language\"},\".emma\":{\"type\":\"application/emma+xml\",\"name\":\"Extensible MultiModal Annotation\"},\".ez2\":{\"type\":\"application/vnd.ezpix-album\",\"name\":\"EZPix Secure Photo Album\"},\".ez3\":{\"type\":\"application/vnd.ezpix-package\",\"name\":\"EZPix Secure Photo Album\"},\".fst\":{\"type\":\"image/vnd.fst\",\"name\":\"FAST Search & Transfer ASA\"},\".fvt\":{\"type\":\"video/vnd.fvt\",\"name\":\"FAST Search & Transfer ASA\"},\".fbs\":{\"type\":\"image/vnd.fastbidsheet\",\"name\":\"FastBid Sheet\"},\".fe_launch\":{\"type\":\"application/vnd.denovo.fcselayout-link\",\"name\":\"FCS Express Layout Link\"},\".f4v\":{\"type\":\"video/x-f4v\",\"name\":\"Flash Video\"},\".flv\":{\"type\":\"video/x-flv\",\"name\":\"Flash Video\"},\".fpx\":{\"type\":\"image/vnd.fpx\",\"name\":\"FlashPix\"},\".npx\":{\"type\":\"image/vnd.net-fpx\",\"name\":\"FlashPix\"},\".flx\":{\"type\":\"text/vnd.fmi.flexstor\",\"name\":\"FLEXSTOR\"},\".fli\":{\"type\":\"video/x-fli\",\"name\":\"FLI/FLC Animation Format\"},\".ftc\":{\"type\":\"application/vnd.fluxtime.clip\",\"name\":\"FluxTime Clip\"},\".fdf\":{\"type\":\"application/vnd.fdf\",\"name\":\"Forms Data Format\"},\".f\":{\"type\":\"text/x-fortran\",\"name\":\"Fortran Source File\"},\".mif\":{\"type\":\"application/vnd.mif\",\"name\":\"FrameMaker Interchange Format\"},\".fm\":{\"type\":\"application/vnd.framemaker\",\"name\":\"FrameMaker Normal Format\"},\".fh\":{\"type\":\"image/x-freehand\",\"name\":\"FreeHand MX\"},\".fsc\":{\"type\":\"application/vnd.fsc.weblaunch\",\"name\":\"Friendly Software Corporation\"},\".fnc\":{\"type\":\"application/vnd.frogans.fnc\",\"name\":\"Frogans Player\"},\".ltf\":{\"type\":\"application/vnd.frogans.ltf\",\"name\":\"Frogans Player\"},\".ddd\":{\"type\":\"application/vnd.fujixerox.ddd\",\"name\":\"Fujitsu - Xerox 2D CAD Data\"},\".xdw\":{\"type\":\"application/vnd.fujixerox.docuworks\",\"name\":\"Fujitsu - Xerox DocuWorks\"},\".xbd\":{\"type\":\"application/vnd.fujixerox.docuworks.binder\",\"name\":\"Fujitsu - Xerox DocuWorks Binder\"},\".oas\":{\"type\":\"application/vnd.fujitsu.oasys\",\"name\":\"Fujitsu Oasys\"},\".oa2\":{\"type\":\"application/vnd.fujitsu.oasys2\",\"name\":\"Fujitsu Oasys\"},\".oa3\":{\"type\":\"application/vnd.fujitsu.oasys3\",\"name\":\"Fujitsu Oasys\"},\".fg5\":{\"type\":\"application/vnd.fujitsu.oasysgp\",\"name\":\"Fujitsu Oasys\"},\".bh2\":{\"type\":\"application/vnd.fujitsu.oasysprs\",\"name\":\"Fujitsu Oasys\"},\".spl\":{\"type\":\"application/x-futuresplash\",\"name\":\"FutureSplash Animator\"},\".fzs\":{\"type\":\"application/vnd.fuzzysheet\",\"name\":\"FuzzySheet\"},\".g3\":{\"type\":\"image/g3fax\",\"name\":\"G3 Fax Image\"},\".gmx\":{\"type\":\"application/vnd.gmx\",\"name\":\"GameMaker ActiveX\"},\".gtw\":{\"type\":\"model/vnd.gtw\",\"name\":\"Gen-Trix Studio\"},\".txd\":{\"type\":\"application/vnd.genomatix.tuxedo\",\"name\":\"Genomatix Tuxedo Framework\"},\".ggb\":{\"type\":\"application/vnd.geogebra.file\",\"name\":\"GeoGebra\"},\".ggt\":{\"type\":\"application/vnd.geogebra.tool\",\"name\":\"GeoGebra\"},\".gdl\":{\"type\":\"model/vnd.gdl\",\"name\":\"Geometric Description Language (GDL)\"},\".gex\":{\"type\":\"application/vnd.geometry-explorer\",\"name\":\"GeoMetry Explorer\"},\".gxt\":{\"type\":\"application/vnd.geonext\",\"name\":\"GEONExT and JSXGraph\"},\".g2w\":{\"type\":\"application/vnd.geoplan\",\"name\":\"GeoplanW\"},\".g3w\":{\"type\":\"application/vnd.geospace\",\"name\":\"GeospacW\"},\".gsf\":{\"type\":\"application/x-font-ghostscript\",\"name\":\"Ghostscript Font\"},\".bdf\":{\"type\":\"application/x-font-bdf\",\"name\":\"Glyph Bitmap Distribution Format\"},\".gtar\":{\"type\":\"application/x-gtar\",\"name\":\"GNU Tar Files\"},\".texinfo\":{\"type\":\"application/x-texinfo\",\"name\":\"GNU Texinfo Document\"},\".gnumeric\":{\"type\":\"application/x-gnumeric\",\"name\":\"Gnumeric\"},\".kml\":{\"type\":\"application/vnd.google-earth.kml+xml\",\"name\":\"Google Earth - KML\"},\".kmz\":{\"type\":\"application/vnd.google-earth.kmz\",\"name\":\"Google Earth - Zipped KML\"},\".gqf\":{\"type\":\"application/vnd.grafeq\",\"name\":\"GrafEq\"},\".gif\":{\"type\":\"image/gif\",\"name\":\"Graphics Interchange Format\"},\".gv\":{\"type\":\"text/vnd.graphviz\",\"name\":\"Graphviz\"},\".gac\":{\"type\":\"application/vnd.groove-account\",\"name\":\"Groove - Account\"},\".ghf\":{\"type\":\"application/vnd.groove-help\",\"name\":\"Groove - Help\"},\".gim\":{\"type\":\"application/vnd.groove-identity-message\",\"name\":\"Groove - Identity Message\"},\".grv\":{\"type\":\"application/vnd.groove-injector\",\"name\":\"Groove - Injector\"},\".gtm\":{\"type\":\"application/vnd.groove-tool-message\",\"name\":\"Groove - Tool Message\"},\".tpl\":{\"type\":\"application/vnd.groove-tool-template\",\"name\":\"Groove - Tool Template\"},\".vcg\":{\"type\":\"application/vnd.groove-vcard\",\"name\":\"Groove - Vcard\"},\".h261\":{\"type\":\"video/h261\",\"name\":\"H.261\"},\".h263\":{\"type\":\"video/h263\",\"name\":\"H.263\"},\".h264\":{\"type\":\"video/h264\",\"name\":\"H.264\"},\".hpid\":{\"type\":\"application/vnd.hp-hpid\",\"name\":\"Hewlett Packard Instant Delivery\"},\".hps\":{\"type\":\"application/vnd.hp-hps\",\"name\":\"Hewlett-Packard's WebPrintSmart\"},\".hdf\":{\"type\":\"application/x-hdf\",\"name\":\"Hierarchical Data Format\"},\".rip\":{\"type\":\"audio/vnd.rip\",\"name\":\"Hit'n'Mix\"},\".hbci\":{\"type\":\"application/vnd.hbci\",\"name\":\"Homebanking Computer Interface (HBCI)\"},\".jlt\":{\"type\":\"application/vnd.hp-jlyt\",\"name\":\"HP Indigo Digital Press - Job Layout Languate\"},\".pcl\":{\"type\":\"application/vnd.hp-pcl\",\"name\":\"HP Printer Command Language\"},\".hpgl\":{\"type\":\"application/vnd.hp-hpgl\",\"name\":\"HP-GL/2 and HP RTL\"},\".hvs\":{\"type\":\"application/vnd.yamaha.hv-script\",\"name\":\"HV Script\"},\".hvd\":{\"type\":\"application/vnd.yamaha.hv-dic\",\"name\":\"HV Voice Dictionary\"},\".hvp\":{\"type\":\"application/vnd.yamaha.hv-voice\",\"name\":\"HV Voice Parameter\"},\".sfd-hdstx\":{\"type\":\"application/vnd.hydrostatix.sof-data\",\"name\":\"Hydrostatix Master Suite\"},\".stk\":{\"type\":\"application/hyperstudio\",\"name\":\"Hyperstudio\"},\".hal\":{\"type\":\"application/vnd.hal+xml\",\"name\":\"Hypertext Application Language\"},\".html\":{\"type\":\"text/html\",\"name\":\"HyperText Markup Language (HTML)\"},\".irm\":{\"type\":\"application/vnd.ibm.rights-management\",\"name\":\"IBM DB2 Rights Manager\"},\".sc\":{\"type\":\"application/vnd.ibm.secure-container\",\"name\":\"IBM Electronic Media Management System - Secure Container\"},\".ics\":{\"type\":\"text/calendar\",\"name\":\"iCalendar\"},\".icc\":{\"type\":\"application/vnd.iccprofile\",\"name\":\"ICC profile\"},\".ico\":{\"type\":\"image/x-icon\",\"name\":\"Icon Image\"},\".igl\":{\"type\":\"application/vnd.igloader\",\"name\":\"igLoader\"},\".ief\":{\"type\":\"image/ief\",\"name\":\"Image Exchange Format\"},\".ivp\":{\"type\":\"application/vnd.immervision-ivp\",\"name\":\"ImmerVision PURE Players\"},\".ivu\":{\"type\":\"application/vnd.immervision-ivu\",\"name\":\"ImmerVision PURE Players\"},\".rif\":{\"type\":\"application/reginfo+xml\",\"name\":\"IMS Networks\"},\".3dml\":{\"type\":\"text/vnd.in3d.3dml\",\"name\":\"In3D - 3DML\"},\".spot\":{\"type\":\"text/vnd.in3d.spot\",\"name\":\"In3D - 3DML\"},\".igs\":{\"type\":\"model/iges\",\"name\":\"Initial Graphics Exchange Specification (IGES)\"},\".i2g\":{\"type\":\"application/vnd.intergeo\",\"name\":\"Interactive Geometry Software\"},\".cdy\":{\"type\":\"application/vnd.cinderella\",\"name\":\"Interactive Geometry Software Cinderella\"},\".xpw\":{\"type\":\"application/vnd.intercon.formnet\",\"name\":\"Intercon FormNet\"},\".fcs\":{\"type\":\"application/vnd.isac.fcs\",\"name\":\"International Society for Advancement of Cytometry\"},\".ipfix\":{\"type\":\"application/ipfix\",\"name\":\"Internet Protocol Flow Information Export\"},\".cer\":{\"type\":\"application/pkix-cert\",\"name\":\"Internet Public Key Infrastructure - Certificate\"},\".pki\":{\"type\":\"application/pkixcmp\",\"name\":\"Internet Public Key Infrastructure - Certificate Management Protocole\"},\".crl\":{\"type\":\"application/pkix-crl\",\"name\":\"Internet Public Key Infrastructure - Certificate Revocation Lists\"},\".pkipath\":{\"type\":\"application/pkix-pkipath\",\"name\":\"Internet Public Key Infrastructure - Certification Path\"},\".igm\":{\"type\":\"application/vnd.insors.igm\",\"name\":\"IOCOM Visimeet\"},\".rcprofile\":{\"type\":\"application/vnd.ipunplugged.rcprofile\",\"name\":\"IP Unplugged Roaming Client\"},\".irp\":{\"type\":\"application/vnd.irepository.package+xml\",\"name\":\"iRepository / Lucidoc Editor\"},\".jad\":{\"type\":\"text/vnd.sun.j2me.app-descriptor\",\"name\":\"J2ME App Descriptor\"},\".jar\":{\"type\":\"application/java-archive\",\"name\":\"Java Archive\"},\".class\":{\"type\":\"application/java-vm\",\"name\":\"Java Bytecode File\"},\".jnlp\":{\"type\":\"application/x-java-jnlp-file\",\"name\":\"Java Network Launching Protocol\"},\".ser\":{\"type\":\"application/java-serialized-object\",\"name\":\"Java Serialized Object\"},\".java\":{\"type\":\"text/x-java-source,java\",\"name\":\"Java Source File\"},\".js\":{\"type\":\"application/javascript\",\"name\":\"JavaScript\"},\".json\":{\"type\":\"application/json\",\"name\":\"JavaScript Object Notation (JSON)\"},\".joda\":{\"type\":\"application/vnd.joost.joda-archive\",\"name\":\"Joda Archive\"},\".jpm\":{\"type\":\"video/jpm\",\"name\":\"JPEG 2000 Compound Image File Format\"},\".jpeg\":{\"type\":\"image/jpeg\",\"name\":\"JPEG Image\"},\".jpg\":{\"type\":\"image/jpeg\",\"name\":\"JPEG Image\"},\".pjpeg\":{\"type\":\"image/pjpeg\",\"name\":\"JPEG Image (Progressive)\"},\".jpgv\":{\"type\":\"video/jpeg\",\"name\":\"JPGVideo\"},\".ktz\":{\"type\":\"application/vnd.kahootz\",\"name\":\"Kahootz\"},\".mmd\":{\"type\":\"application/vnd.chipnuts.karaoke-mmd\",\"name\":\"Karaoke on Chipnuts Chipsets\"},\".karbon\":{\"type\":\"application/vnd.kde.karbon\",\"name\":\"KDE KOffice Office Suite - Karbon\"},\".chrt\":{\"type\":\"application/vnd.kde.kchart\",\"name\":\"KDE KOffice Office Suite - KChart\"},\".kfo\":{\"type\":\"application/vnd.kde.kformula\",\"name\":\"KDE KOffice Office Suite - Kformula\"},\".flw\":{\"type\":\"application/vnd.kde.kivio\",\"name\":\"KDE KOffice Office Suite - Kivio\"},\".kon\":{\"type\":\"application/vnd.kde.kontour\",\"name\":\"KDE KOffice Office Suite - Kontour\"},\".kpr\":{\"type\":\"application/vnd.kde.kpresenter\",\"name\":\"KDE KOffice Office Suite - Kpresenter\"},\".ksp\":{\"type\":\"application/vnd.kde.kspread\",\"name\":\"KDE KOffice Office Suite - Kspread\"},\".kwd\":{\"type\":\"application/vnd.kde.kword\",\"name\":\"KDE KOffice Office Suite - Kword\"},\".htke\":{\"type\":\"application/vnd.kenameaapp\",\"name\":\"Kenamea App\"},\".kia\":{\"type\":\"application/vnd.kidspiration\",\"name\":\"Kidspiration\"},\".kne\":{\"type\":\"application/vnd.kinar\",\"name\":\"Kinar Applications\"},\".sse\":{\"type\":\"application/vnd.kodak-descriptor\",\"name\":\"Kodak Storyshare\"},\".lasxml\":{\"type\":\"application/vnd.las.las+xml\",\"name\":\"Laser App Enterprise\"},\".latex\":{\"type\":\"application/x-latex\",\"name\":\"LaTeX\"},\".lbd\":{\"type\":\"application/vnd.llamagraphics.life-balance.desktop\",\"name\":\"Life Balance - Desktop Edition\"},\".lbe\":{\"type\":\"application/vnd.llamagraphics.life-balance.exchange+xml\",\"name\":\"Life Balance - Exchange Format\"},\".jam\":{\"type\":\"application/vnd.jam\",\"name\":\"Lightspeed Audio Lab\"},\".123\":{\"type\":\"application/vnd.lotus-1-2-3\",\"name\":\"Lotus 1-2-3\"},\".apr\":{\"type\":\"application/vnd.lotus-approach\",\"name\":\"Lotus Approach\"},\".pre\":{\"type\":\"application/vnd.lotus-freelance\",\"name\":\"Lotus Freelance\"},\".nsf\":{\"type\":\"application/vnd.lotus-notes\",\"name\":\"Lotus Notes\"},\".org\":{\"type\":\"application/vnd.lotus-organizer\",\"name\":\"Lotus Organizer\"},\".scm\":{\"type\":\"application/vnd.lotus-screencam\",\"name\":\"Lotus Screencam\"},\".lwp\":{\"type\":\"application/vnd.lotus-wordpro\",\"name\":\"Lotus Wordpro\"},\".lvp\":{\"type\":\"audio/vnd.lucent.voice\",\"name\":\"Lucent Voice\"},\".m3u\":{\"type\":\"audio/x-mpegurl\",\"name\":\"M3U (Multimedia Playlist)\"},\".m4v\":{\"type\":\"video/x-m4v\",\"name\":\"M4v\"},\".hqx\":{\"type\":\"application/mac-binhex40\",\"name\":\"Macintosh BinHex 4.0\"},\".portpkg\":{\"type\":\"application/vnd.macports.portpkg\",\"name\":\"MacPorts Port System\"},\".mgp\":{\"type\":\"application/vnd.osgeo.mapguide.package\",\"name\":\"MapGuide DBXML\"},\".mrc\":{\"type\":\"application/marc\",\"name\":\"MARC Formats\"},\".mrcx\":{\"type\":\"application/marcxml+xml\",\"name\":\"MARC21 XML Schema\"},\".mxf\":{\"type\":\"application/mxf\",\"name\":\"Material Exchange Format\"},\".nbp\":{\"type\":\"application/vnd.wolfram.player\",\"name\":\"Mathematica Notebook Player\"},\".ma\":{\"type\":\"application/mathematica\",\"name\":\"Mathematica Notebooks\"},\".mathml\":{\"type\":\"application/mathml+xml\",\"name\":\"Mathematical Markup Language\"},\".mbox\":{\"type\":\"application/mbox\",\"name\":\"Mbox database files\"},\".mc1\":{\"type\":\"application/vnd.medcalcdata\",\"name\":\"MedCalc\"},\".mscml\":{\"type\":\"application/mediaservercontrol+xml\",\"name\":\"Media Server Control Markup Language\"},\".cdkey\":{\"type\":\"application/vnd.mediastation.cdkey\",\"name\":\"MediaRemote\"},\".mwf\":{\"type\":\"application/vnd.mfer\",\"name\":\"Medical Waveform Encoding Format\"},\".mfm\":{\"type\":\"application/vnd.mfmp\",\"name\":\"Melody Format for Mobile Platform\"},\".msh\":{\"type\":\"model/mesh\",\"name\":\"Mesh Data Type\"},\".mads\":{\"type\":\"application/mads+xml\",\"name\":\"Metadata Authority Description Schema\"},\".mets\":{\"type\":\"application/mets+xml\",\"name\":\"Metadata Encoding and Transmission Standard\"},\".mods\":{\"type\":\"application/mods+xml\",\"name\":\"Metadata Object Description Schema\"},\".meta4\":{\"type\":\"application/metalink4+xml\",\"name\":\"Metalink\"},\".mcd\":{\"type\":\"application/vnd.mcd\",\"name\":\"Micro CADAM Helix D&D\"},\".flo\":{\"type\":\"application/vnd.micrografx.flo\",\"name\":\"Micrografx\"},\".igx\":{\"type\":\"application/vnd.micrografx.igx\",\"name\":\"Micrografx iGrafx Professional\"},\".es3\":{\"type\":\"application/vnd.eszigno3+xml\",\"name\":\"MICROSEC e-Szign¢\"},\".mdb\":{\"type\":\"application/x-msaccess\",\"name\":\"Microsoft Access\"},\".asf\":{\"type\":\"video/x-ms-asf\",\"name\":\"Microsoft Advanced Systems Format (ASF)\"},\".exe\":{\"type\":\"application/x-msdownload\",\"name\":\"Microsoft Application\"},\".cil\":{\"type\":\"application/vnd.ms-artgalry\",\"name\":\"Microsoft Artgalry\"},\".cab\":{\"type\":\"application/vnd.ms-cab-compressed\",\"name\":\"Microsoft Cabinet File\"},\".ims\":{\"type\":\"application/vnd.ms-ims\",\"name\":\"Microsoft Class Server\"},\".application\":{\"type\":\"application/x-ms-application\",\"name\":\"Microsoft ClickOnce\"},\".clp\":{\"type\":\"application/x-msclip\",\"name\":\"Microsoft Clipboard Clip\"},\".mdi\":{\"type\":\"image/vnd.ms-modi\",\"name\":\"Microsoft Document Imaging Format\"},\".eot\":{\"type\":\"application/vnd.ms-fontobject\",\"name\":\"Microsoft Embedded OpenType\"},\".xls\":{\"type\":\"application/vnd.ms-excel\",\"name\":\"Microsoft Excel\"},\".xlam\":{\"type\":\"application/vnd.ms-excel.addin.macroenabled.12\",\"name\":\"Microsoft Excel - Add-In File\"},\".xlsb\":{\"type\":\"application/vnd.ms-excel.sheet.binary.macroenabled.12\",\"name\":\"Microsoft Excel - Binary Workbook\"},\".xltm\":{\"type\":\"application/vnd.ms-excel.template.macroenabled.12\",\"name\":\"Microsoft Excel - Macro-Enabled Template File\"},\".xlsm\":{\"type\":\"application/vnd.ms-excel.sheet.macroenabled.12\",\"name\":\"Microsoft Excel - Macro-Enabled Workbook\"},\".chm\":{\"type\":\"application/vnd.ms-htmlhelp\",\"name\":\"Microsoft Html Help File\"},\".crd\":{\"type\":\"application/x-mscardfile\",\"name\":\"Microsoft Information Card\"},\".lrm\":{\"type\":\"application/vnd.ms-lrm\",\"name\":\"Microsoft Learning Resource Module\"},\".mvb\":{\"type\":\"application/x-msmediaview\",\"name\":\"Microsoft MediaView\"},\".mny\":{\"type\":\"application/x-msmoney\",\"name\":\"Microsoft Money\"},\".pptx\":{\"type\":\"application/vnd.openxmlformats-officedocument.presentationml.presentation\",\"name\":\"Microsoft Office - OOXML - Presentation\"},\".sldx\":{\"type\":\"application/vnd.openxmlformats-officedocument.presentationml.slide\",\"name\":\"Microsoft Office - OOXML - Presentation (Slide)\"},\".ppsx\":{\"type\":\"application/vnd.openxmlformats-officedocument.presentationml.slideshow\",\"name\":\"Microsoft Office - OOXML - Presentation (Slideshow)\"},\".potx\":{\"type\":\"application/vnd.openxmlformats-officedocument.presentationml.template\",\"name\":\"Microsoft Office - OOXML - Presentation Template\"},\".xlsx\":{\"type\":\"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet\",\"name\":\"Microsoft Office - OOXML - Spreadsheet\"},\".xltx\":{\"type\":\"application/vnd.openxmlformats-officedocument.spreadsheetml.template\",\"name\":\"Microsoft Office - OOXML - Spreadsheet Template\"},\".docx\":{\"type\":\"application/vnd.openxmlformats-officedocument.wordprocessingml.document\",\"name\":\"Microsoft Office - OOXML - Word Document\"},\".dotx\":{\"type\":\"application/vnd.openxmlformats-officedocument.wordprocessingml.template\",\"name\":\"Microsoft Office - OOXML - Word Document Template\"},\".obd\":{\"type\":\"application/x-msbinder\",\"name\":\"Microsoft Office Binder\"},\".thmx\":{\"type\":\"application/vnd.ms-officetheme\",\"name\":\"Microsoft Office System Release Theme\"},\".onetoc\":{\"type\":\"application/onenote\",\"name\":\"Microsoft OneNote\"},\".pya\":{\"type\":\"audio/vnd.ms-playready.media.pya\",\"name\":\"Microsoft PlayReady Ecosystem\"},\".pyv\":{\"type\":\"video/vnd.ms-playready.media.pyv\",\"name\":\"Microsoft PlayReady Ecosystem Video\"},\".ppt\":{\"type\":\"application/vnd.ms-powerpoint\",\"name\":\"Microsoft PowerPoint\"},\".ppam\":{\"type\":\"application/vnd.ms-powerpoint.addin.macroenabled.12\",\"name\":\"Microsoft PowerPoint - Add-in file\"},\".sldm\":{\"type\":\"application/vnd.ms-powerpoint.slide.macroenabled.12\",\"name\":\"Microsoft PowerPoint - Macro-Enabled Open XML Slide\"},\".pptm\":{\"type\":\"application/vnd.ms-powerpoint.presentation.macroenabled.12\",\"name\":\"Microsoft PowerPoint - Macro-Enabled Presentation File\"},\".ppsm\":{\"type\":\"application/vnd.ms-powerpoint.slideshow.macroenabled.12\",\"name\":\"Microsoft PowerPoint - Macro-Enabled Slide Show File\"},\".potm\":{\"type\":\"application/vnd.ms-powerpoint.template.macroenabled.12\",\"name\":\"Microsoft PowerPoint - Macro-Enabled Template File\"},\".mpp\":{\"type\":\"application/vnd.ms-project\",\"name\":\"Microsoft Project\"},\".pub\":{\"type\":\"application/x-mspublisher\",\"name\":\"Microsoft Publisher\"},\".scd\":{\"type\":\"application/x-msschedule\",\"name\":\"Microsoft Schedule+\"},\".xap\":{\"type\":\"application/x-silverlight-app\",\"name\":\"Microsoft Silverlight\"},\".stl\":{\"type\":\"application/vnd.ms-pki.stl\",\"name\":\"Microsoft Trust UI Provider - Certificate Trust Link\"},\".cat\":{\"type\":\"application/vnd.ms-pki.seccat\",\"name\":\"Microsoft Trust UI Provider - Security Catalog\"},\".vsd\":{\"type\":\"application/vnd.visio\",\"name\":\"Microsoft Visio\"},\".vsdx\":{\"type\":\"application/vnd.visio2013\",\"name\":\"Microsoft Visio 2013\"},\".wm\":{\"type\":\"video/x-ms-wm\",\"name\":\"Microsoft Windows Media\"},\".wma\":{\"type\":\"audio/x-ms-wma\",\"name\":\"Microsoft Windows Media Audio\"},\".wax\":{\"type\":\"audio/x-ms-wax\",\"name\":\"Microsoft Windows Media Audio Redirector\"},\".wmx\":{\"type\":\"video/x-ms-wmx\",\"name\":\"Microsoft Windows Media Audio/Video Playlist\"},\".wmd\":{\"type\":\"application/x-ms-wmd\",\"name\":\"Microsoft Windows Media Player Download Package\"},\".wpl\":{\"type\":\"application/vnd.ms-wpl\",\"name\":\"Microsoft Windows Media Player Playlist\"},\".wmz\":{\"type\":\"application/x-ms-wmz\",\"name\":\"Microsoft Windows Media Player Skin Package\"},\".wmv\":{\"type\":\"video/x-ms-wmv\",\"name\":\"Microsoft Windows Media Video\"},\".wvx\":{\"type\":\"video/x-ms-wvx\",\"name\":\"Microsoft Windows Media Video Playlist\"},\".wmf\":{\"type\":\"application/x-msmetafile\",\"name\":\"Microsoft Windows Metafile\"},\".trm\":{\"type\":\"application/x-msterminal\",\"name\":\"Microsoft Windows Terminal Services\"},\".doc\":{\"type\":\"application/msword\",\"name\":\"Microsoft Word\"},\".docm\":{\"type\":\"application/vnd.ms-word.document.macroenabled.12\",\"name\":\"Microsoft Word - Macro-Enabled Document\"},\".dotm\":{\"type\":\"application/vnd.ms-word.template.macroenabled.12\",\"name\":\"Microsoft Word - Macro-Enabled Template\"},\".wri\":{\"type\":\"application/x-mswrite\",\"name\":\"Microsoft Wordpad\"},\".wps\":{\"type\":\"application/vnd.ms-works\",\"name\":\"Microsoft Works\"},\".xbap\":{\"type\":\"application/x-ms-xbap\",\"name\":\"Microsoft XAML Browser Application\"},\".xps\":{\"type\":\"application/vnd.ms-xpsdocument\",\"name\":\"Microsoft XML Paper Specification\"},\".mid\":{\"type\":\"audio/midi\",\"name\":\"MIDI - Musical Instrument Digital Interface\"},\".mpy\":{\"type\":\"application/vnd.ibm.minipay\",\"name\":\"MiniPay\"},\".afp\":{\"type\":\"application/vnd.ibm.modcap\",\"name\":\"MO:DCA-P\"},\".rms\":{\"type\":\"application/vnd.jcp.javame.midlet-rms\",\"name\":\"Mobile Information Device Profile\"},\".tmo\":{\"type\":\"application/vnd.tmobile-livetv\",\"name\":\"MobileTV\"},\".prc\":{\"type\":\"application/x-mobipocket-ebook\",\"name\":\"Mobipocket\"},\".mbk\":{\"type\":\"application/vnd.mobius.mbk\",\"name\":\"Mobius Management Systems - Basket file\"},\".dis\":{\"type\":\"application/vnd.mobius.dis\",\"name\":\"Mobius Management Systems - Distribution Database\"},\".plc\":{\"type\":\"application/vnd.mobius.plc\",\"name\":\"Mobius Management Systems - Policy Definition Language File\"},\".mqy\":{\"type\":\"application/vnd.mobius.mqy\",\"name\":\"Mobius Management Systems - Query File\"},\".msl\":{\"type\":\"application/vnd.mobius.msl\",\"name\":\"Mobius Management Systems - Script Language\"},\".txf\":{\"type\":\"application/vnd.mobius.txf\",\"name\":\"Mobius Management Systems - Topic Index File\"},\".daf\":{\"type\":\"application/vnd.mobius.daf\",\"name\":\"Mobius Management Systems - UniversalArchive\"},\".fly\":{\"type\":\"text/vnd.fly\",\"name\":\"mod_fly / fly.cgi\"},\".mpc\":{\"type\":\"application/vnd.mophun.certificate\",\"name\":\"Mophun Certificate\"},\".mpn\":{\"type\":\"application/vnd.mophun.application\",\"name\":\"Mophun VM\"},\".mj2\":{\"type\":\"video/mj2\",\"name\":\"Motion JPEG 2000\"},\".mpga\":{\"type\":\"audio/mpeg\",\"name\":\"MPEG Audio\"},\".mxu\":{\"type\":\"video/vnd.mpegurl\",\"name\":\"MPEG Url\"},\".mpeg\":{\"type\":\"video/mpeg\",\"name\":\"MPEG Video\"},\".m21\":{\"type\":\"application/mp21\",\"name\":\"MPEG-21\"},\".mp4a\":{\"type\":\"audio/mp4\",\"name\":\"MPEG-4 Audio\"},\".mp4\":{\"type\":\"video/mp4\",\"name\":\"MPEG-4 Video\"},\".m3u8\":{\"type\":\"application/vnd.apple.mpegurl\",\"name\":\"Multimedia Playlist Unicode\"},\".mus\":{\"type\":\"application/vnd.musician\",\"name\":\"MUsical Score Interpreted Code Invented for the ASCII designation of Notation\"},\".msty\":{\"type\":\"application/vnd.muvee.style\",\"name\":\"Muvee Automatic Video Editing\"},\".mxml\":{\"type\":\"application/xv+xml\",\"name\":\"MXML\"},\".ngdat\":{\"type\":\"application/vnd.nokia.n-gage.data\",\"name\":\"N-Gage Game Data\"},\".n-gage\":{\"type\":\"application/vnd.nokia.n-gage.symbian.install\",\"name\":\"N-Gage Game Installer\"},\".ncx\":{\"type\":\"application/x-dtbncx+xml\",\"name\":\"Navigation Control file for XML (for ePub)\"},\".nc\":{\"type\":\"application/x-netcdf\",\"name\":\"Network Common Data Form (NetCDF)\"},\".nlu\":{\"type\":\"application/vnd.neurolanguage.nlu\",\"name\":\"neuroLanguage\"},\".dna\":{\"type\":\"application/vnd.dna\",\"name\":\"New Moon Liftoff/DNA\"},\".nnd\":{\"type\":\"application/vnd.noblenet-directory\",\"name\":\"NobleNet Directory\"},\".nns\":{\"type\":\"application/vnd.noblenet-sealer\",\"name\":\"NobleNet Sealer\"},\".nnw\":{\"type\":\"application/vnd.noblenet-web\",\"name\":\"NobleNet Web\"},\".rpst\":{\"type\":\"application/vnd.nokia.radio-preset\",\"name\":\"Nokia Radio Application - Preset\"},\".rpss\":{\"type\":\"application/vnd.nokia.radio-presets\",\"name\":\"Nokia Radio Application - Preset\"},\".n3\":{\"type\":\"text/n3\",\"name\":\"Notation3\"},\".edm\":{\"type\":\"application/vnd.novadigm.edm\",\"name\":\"Novadigm's RADIA and EDM products\"},\".edx\":{\"type\":\"application/vnd.novadigm.edx\",\"name\":\"Novadigm's RADIA and EDM products\"},\".ext\":{\"type\":\"application/vnd.novadigm.ext\",\"name\":\"Novadigm's RADIA and EDM products\"},\".gph\":{\"type\":\"application/vnd.flographit\",\"name\":\"NpGraphIt\"},\".ecelp4800\":{\"type\":\"audio/vnd.nuera.ecelp4800\",\"name\":\"Nuera ECELP 4800\"},\".ecelp7470\":{\"type\":\"audio/vnd.nuera.ecelp7470\",\"name\":\"Nuera ECELP 7470\"},\".ecelp9600\":{\"type\":\"audio/vnd.nuera.ecelp9600\",\"name\":\"Nuera ECELP 9600\"},\".oda\":{\"type\":\"application/oda\",\"name\":\"Office Document Architecture\"},\".ogx\":{\"type\":\"application/ogg\",\"name\":\"Ogg\"},\".oga\":{\"type\":\"audio/ogg\",\"name\":\"Ogg Audio\"},\".ogv\":{\"type\":\"video/ogg\",\"name\":\"Ogg Video\"},\".dd2\":{\"type\":\"application/vnd.oma.dd2+xml\",\"name\":\"OMA Download Agents\"},\".oth\":{\"type\":\"application/vnd.oasis.opendocument.text-web\",\"name\":\"Open Document Text Web\"},\".opf\":{\"type\":\"application/oebps-package+xml\",\"name\":\"Open eBook Publication Structure\"},\".qbo\":{\"type\":\"application/vnd.intu.qbo\",\"name\":\"Open Financial Exchange\"},\".oxt\":{\"type\":\"application/vnd.openofficeorg.extension\",\"name\":\"Open Office Extension\"},\".osf\":{\"type\":\"application/vnd.yamaha.openscoreformat\",\"name\":\"Open Score Format\"},\".weba\":{\"type\":\"audio/webm\",\"name\":\"Open Web Media Project - Audio\"},\".webm\":{\"type\":\"video/webm\",\"name\":\"Open Web Media Project - Video\"},\".odc\":{\"type\":\"application/vnd.oasis.opendocument.chart\",\"name\":\"OpenDocument Chart\"},\".otc\":{\"type\":\"application/vnd.oasis.opendocument.chart-template\",\"name\":\"OpenDocument Chart Template\"},\".odb\":{\"type\":\"application/vnd.oasis.opendocument.database\",\"name\":\"OpenDocument Database\"},\".odf\":{\"type\":\"application/vnd.oasis.opendocument.formula\",\"name\":\"OpenDocument Formula\"},\".odft\":{\"type\":\"application/vnd.oasis.opendocument.formula-template\",\"name\":\"OpenDocument Formula Template\"},\".odg\":{\"type\":\"application/vnd.oasis.opendocument.graphics\",\"name\":\"OpenDocument Graphics\"},\".otg\":{\"type\":\"application/vnd.oasis.opendocument.graphics-template\",\"name\":\"OpenDocument Graphics Template\"},\".odi\":{\"type\":\"application/vnd.oasis.opendocument.image\",\"name\":\"OpenDocument Image\"},\".oti\":{\"type\":\"application/vnd.oasis.opendocument.image-template\",\"name\":\"OpenDocument Image Template\"},\".odp\":{\"type\":\"application/vnd.oasis.opendocument.presentation\",\"name\":\"OpenDocument Presentation\"},\".otp\":{\"type\":\"application/vnd.oasis.opendocument.presentation-template\",\"name\":\"OpenDocument Presentation Template\"},\".ods\":{\"type\":\"application/vnd.oasis.opendocument.spreadsheet\",\"name\":\"OpenDocument Spreadsheet\"},\".ots\":{\"type\":\"application/vnd.oasis.opendocument.spreadsheet-template\",\"name\":\"OpenDocument Spreadsheet Template\"},\".odt\":{\"type\":\"application/vnd.oasis.opendocument.text\",\"name\":\"OpenDocument Text\"},\".odm\":{\"type\":\"application/vnd.oasis.opendocument.text-master\",\"name\":\"OpenDocument Text Master\"},\".ott\":{\"type\":\"application/vnd.oasis.opendocument.text-template\",\"name\":\"OpenDocument Text Template\"},\".ktx\":{\"type\":\"image/ktx\",\"name\":\"OpenGL Textures (KTX)\"},\".sxc\":{\"type\":\"application/vnd.sun.xml.calc\",\"name\":\"OpenOffice - Calc (Spreadsheet)\"},\".stc\":{\"type\":\"application/vnd.sun.xml.calc.template\",\"name\":\"OpenOffice - Calc Template (Spreadsheet)\"},\".sxd\":{\"type\":\"application/vnd.sun.xml.draw\",\"name\":\"OpenOffice - Draw (Graphics)\"},\".std\":{\"type\":\"application/vnd.sun.xml.draw.template\",\"name\":\"OpenOffice - Draw Template (Graphics)\"},\".sxi\":{\"type\":\"application/vnd.sun.xml.impress\",\"name\":\"OpenOffice - Impress (Presentation)\"},\".sti\":{\"type\":\"application/vnd.sun.xml.impress.template\",\"name\":\"OpenOffice - Impress Template (Presentation)\"},\".sxm\":{\"type\":\"application/vnd.sun.xml.math\",\"name\":\"OpenOffice - Math (Formula)\"},\".sxw\":{\"type\":\"application/vnd.sun.xml.writer\",\"name\":\"OpenOffice - Writer (Text - HTML)\"},\".sxg\":{\"type\":\"application/vnd.sun.xml.writer.global\",\"name\":\"OpenOffice - Writer (Text - HTML)\"},\".stw\":{\"type\":\"application/vnd.sun.xml.writer.template\",\"name\":\"OpenOffice - Writer Template (Text - HTML)\"},\".otf\":{\"type\":\"application/x-font-otf\",\"name\":\"OpenType Font File\"},\".osfpvg\":{\"type\":\"application/vnd.yamaha.openscoreformat.osfpvg+xml\",\"name\":\"OSFPVG\"},\".dp\":{\"type\":\"application/vnd.osgi.dp\",\"name\":\"OSGi Deployment Package\"},\".pdb\":{\"type\":\"application/vnd.palm\",\"name\":\"PalmOS Data\"},\".p\":{\"type\":\"text/x-pascal\",\"name\":\"Pascal Source File\"},\".paw\":{\"type\":\"application/vnd.pawaafile\",\"name\":\"PawaaFILE\"},\".pclxl\":{\"type\":\"application/vnd.hp-pclxl\",\"name\":\"PCL 6 Enhanced (Formely PCL XL)\"},\".efif\":{\"type\":\"application/vnd.picsel\",\"name\":\"Pcsel eFIF File\"},\".pcx\":{\"type\":\"image/x-pcx\",\"name\":\"PCX Image\"},\".psd\":{\"type\":\"image/vnd.adobe.photoshop\",\"name\":\"Photoshop Document\"},\".prf\":{\"type\":\"application/pics-rules\",\"name\":\"PICSRules\"},\".pic\":{\"type\":\"image/x-pict\",\"name\":\"PICT Image\"},\".chat\":{\"type\":\"application/x-chat\",\"name\":\"pIRCh\"},\".p10\":{\"type\":\"application/pkcs10\",\"name\":\"PKCS #10 - Certification Request Standard\"},\".p12\":{\"type\":\"application/x-pkcs12\",\"name\":\"PKCS #12 - Personal Information Exchange Syntax Standard\"},\".p7m\":{\"type\":\"application/pkcs7-mime\",\"name\":\"PKCS #7 - Cryptographic Message Syntax Standard\"},\".p7s\":{\"type\":\"application/pkcs7-signature\",\"name\":\"PKCS #7 - Cryptographic Message Syntax Standard\"},\".p7r\":{\"type\":\"application/x-pkcs7-certreqresp\",\"name\":\"PKCS #7 - Cryptographic Message Syntax Standard (Certificate Request Response)\"},\".p7b\":{\"type\":\"application/x-pkcs7-certificates\",\"name\":\"PKCS #7 - Cryptographic Message Syntax Standard (Certificates)\"},\".p8\":{\"type\":\"application/pkcs8\",\"name\":\"PKCS #8 - Private-Key Information Syntax Standard\"},\".plf\":{\"type\":\"application/vnd.pocketlearn\",\"name\":\"PocketLearn Viewers\"},\".pnm\":{\"type\":\"image/x-portable-anymap\",\"name\":\"Portable Anymap Image\"},\".pbm\":{\"type\":\"image/x-portable-bitmap\",\"name\":\"Portable Bitmap Format\"},\".pcf\":{\"type\":\"application/x-font-pcf\",\"name\":\"Portable Compiled Format\"},\".pfr\":{\"type\":\"application/font-tdpfr\",\"name\":\"Portable Font Resource\"},\".pgn\":{\"type\":\"application/x-chess-pgn\",\"name\":\"Portable Game Notation (Chess Games)\"},\".pgm\":{\"type\":\"image/x-portable-graymap\",\"name\":\"Portable Graymap Format\"},\".png\":{\"type\":\"image/png\",\"name\":\"Portable Network Graphics (PNG)\"},\".ppm\":{\"type\":\"image/x-portable-pixmap\",\"name\":\"Portable Pixmap Format\"},\".pskcxml\":{\"type\":\"application/pskc+xml\",\"name\":\"Portable Symmetric Key Container\"},\".pml\":{\"type\":\"application/vnd.ctc-posml\",\"name\":\"PosML\"},\".ai\":{\"type\":\"application/postscript\",\"name\":\"PostScript\"},\".pfa\":{\"type\":\"application/x-font-type1\",\"name\":\"PostScript Fonts\"},\".pbd\":{\"type\":\"application/vnd.powerbuilder6\",\"name\":\"PowerBuilder\"},\".pgp\":{\"type\":\"application/pgp-encrypted\",\"name\":\"Pretty Good Privacy\"},\".box\":{\"type\":\"application/vnd.previewsystems.box\",\"name\":\"Preview Systems ZipLock/VBox\"},\".ptid\":{\"type\":\"application/vnd.pvi.ptid1\",\"name\":\"Princeton Video Image\"},\".pls\":{\"type\":\"application/pls+xml\",\"name\":\"Pronunciation Lexicon Specification\"},\".str\":{\"type\":\"application/vnd.pg.format\",\"name\":\"Proprietary P&G Standard Reporting System\"},\".ei6\":{\"type\":\"application/vnd.pg.osasli\",\"name\":\"Proprietary P&G Standard Reporting System\"},\".dsc\":{\"type\":\"text/prs.lines.tag\",\"name\":\"PRS Lines Tag\"},\".psf\":{\"type\":\"application/x-font-linux-psf\",\"name\":\"PSF Fonts\"},\".qps\":{\"type\":\"application/vnd.publishare-delta-tree\",\"name\":\"PubliShare Objects\"},\".wg\":{\"type\":\"application/vnd.pmi.widget\",\"name\":\"Qualcomm's Plaza Mobile Internet\"},\".qxd\":{\"type\":\"application/vnd.quark.quarkxpress\",\"name\":\"QuarkXpress\"},\".esf\":{\"type\":\"application/vnd.epson.esf\",\"name\":\"QUASS Stream Player\"},\".msf\":{\"type\":\"application/vnd.epson.msf\",\"name\":\"QUASS Stream Player\"},\".ssf\":{\"type\":\"application/vnd.epson.ssf\",\"name\":\"QUASS Stream Player\"},\".qam\":{\"type\":\"application/vnd.epson.quickanime\",\"name\":\"QuickAnime Player\"},\".qfx\":{\"type\":\"application/vnd.intu.qfx\",\"name\":\"Quicken\"},\".qt\":{\"type\":\"video/quicktime\",\"name\":\"Quicktime Video\"},\".rar\":{\"type\":\"application/x-rar-compressed\",\"name\":\"RAR Archive\"},\".ram\":{\"type\":\"audio/x-pn-realaudio\",\"name\":\"Real Audio Sound\"},\".rmp\":{\"type\":\"audio/x-pn-realaudio-plugin\",\"name\":\"Real Audio Sound\"},\".rsd\":{\"type\":\"application/rsd+xml\",\"name\":\"Really Simple Discovery\"},\".rm\":{\"type\":\"application/vnd.rn-realmedia\",\"name\":\"RealMedia\"},\".bed\":{\"type\":\"application/vnd.realvnc.bed\",\"name\":\"RealVNC\"},\".mxl\":{\"type\":\"application/vnd.recordare.musicxml\",\"name\":\"Recordare Applications\"},\".musicxml\":{\"type\":\"application/vnd.recordare.musicxml+xml\",\"name\":\"Recordare Applications\"},\".rnc\":{\"type\":\"application/relax-ng-compact-syntax\",\"name\":\"Relax NG Compact Syntax\"},\".rdz\":{\"type\":\"application/vnd.data-vision.rdz\",\"name\":\"RemoteDocs R-Viewer\"},\".rdf\":{\"type\":\"application/rdf+xml\",\"name\":\"Resource Description Framework\"},\".rp9\":{\"type\":\"application/vnd.cloanto.rp9\",\"name\":\"RetroPlatform Player\"},\".jisp\":{\"type\":\"application/vnd.jisp\",\"name\":\"RhymBox\"},\".rtf\":{\"type\":\"application/rtf\",\"name\":\"Rich Text Format\"},\".rtx\":{\"type\":\"text/richtext\",\"name\":\"Rich Text Format (RTF)\"},\".link66\":{\"type\":\"application/vnd.route66.link66+xml\",\"name\":\"ROUTE 66 Location Based Services\"},\".rss\":{\"type\":\"application/rss+xml\",\"name\":\"RSS - Really Simple Syndication\"},\".shf\":{\"type\":\"application/shf+xml\",\"name\":\"S Hexdump Format\"},\".st\":{\"type\":\"application/vnd.sailingtracker.track\",\"name\":\"SailingTracker\"},\".svg\":{\"type\":\"image/svg+xml\",\"name\":\"Scalable Vector Graphics (SVG)\"},\".sus\":{\"type\":\"application/vnd.sus-calendar\",\"name\":\"ScheduleUs\"},\".sru\":{\"type\":\"application/sru+xml\",\"name\":\"Search/Retrieve via URL Response Format\"},\".setpay\":{\"type\":\"application/set-payment-initiation\",\"name\":\"Secure Electronic Transaction - Payment\"},\".setreg\":{\"type\":\"application/set-registration-initiation\",\"name\":\"Secure Electronic Transaction - Registration\"},\".sema\":{\"type\":\"application/vnd.sema\",\"name\":\"Secured eMail\"},\".semd\":{\"type\":\"application/vnd.semd\",\"name\":\"Secured eMail\"},\".semf\":{\"type\":\"application/vnd.semf\",\"name\":\"Secured eMail\"},\".see\":{\"type\":\"application/vnd.seemail\",\"name\":\"SeeMail\"},\".snf\":{\"type\":\"application/x-font-snf\",\"name\":\"Server Normal Format\"},\".spq\":{\"type\":\"application/scvp-vp-request\",\"name\":\"Server-Based Certificate Validation Protocol - Validation Policies - Request\"},\".spp\":{\"type\":\"application/scvp-vp-response\",\"name\":\"Server-Based Certificate Validation Protocol - Validation Policies - Response\"},\".scq\":{\"type\":\"application/scvp-cv-request\",\"name\":\"Server-Based Certificate Validation Protocol - Validation Request\"},\".scs\":{\"type\":\"application/scvp-cv-response\",\"name\":\"Server-Based Certificate Validation Protocol - Validation Response\"},\".sdp\":{\"type\":\"application/sdp\",\"name\":\"Session Description Protocol\"},\".etx\":{\"type\":\"text/x-setext\",\"name\":\"Setext\"},\".movie\":{\"type\":\"video/x-sgi-movie\",\"name\":\"SGI Movie\"},\".ifm\":{\"type\":\"application/vnd.shana.informed.formdata\",\"name\":\"Shana Informed Filler\"},\".itp\":{\"type\":\"application/vnd.shana.informed.formtemplate\",\"name\":\"Shana Informed Filler\"},\".iif\":{\"type\":\"application/vnd.shana.informed.interchange\",\"name\":\"Shana Informed Filler\"},\".ipk\":{\"type\":\"application/vnd.shana.informed.package\",\"name\":\"Shana Informed Filler\"},\".tfi\":{\"type\":\"application/thraud+xml\",\"name\":\"Sharing Transaction Fraud Data\"},\".shar\":{\"type\":\"application/x-shar\",\"name\":\"Shell Archive\"},\".rgb\":{\"type\":\"image/x-rgb\",\"name\":\"Silicon Graphics RGB Bitmap\"},\".slt\":{\"type\":\"application/vnd.epson.salt\",\"name\":\"SimpleAnimeLite Player\"},\".aso\":{\"type\":\"application/vnd.accpac.simply.aso\",\"name\":\"Simply Accounting\"},\".imp\":{\"type\":\"application/vnd.accpac.simply.imp\",\"name\":\"Simply Accounting - Data Import\"},\".twd\":{\"type\":\"application/vnd.simtech-mindmapper\",\"name\":\"SimTech MindMapper\"},\".csp\":{\"type\":\"application/vnd.commonspace\",\"name\":\"Sixth Floor Media - CommonSpace\"},\".saf\":{\"type\":\"application/vnd.yamaha.smaf-audio\",\"name\":\"SMAF Audio\"},\".mmf\":{\"type\":\"application/vnd.smaf\",\"name\":\"SMAF File\"},\".spf\":{\"type\":\"application/vnd.yamaha.smaf-phrase\",\"name\":\"SMAF Phrase\"},\".teacher\":{\"type\":\"application/vnd.smart.teacher\",\"name\":\"SMART Technologies Apps\"},\".svd\":{\"type\":\"application/vnd.svd\",\"name\":\"SourceView Document\"},\".rq\":{\"type\":\"application/sparql-query\",\"name\":\"SPARQL - Query\"},\".srx\":{\"type\":\"application/sparql-results+xml\",\"name\":\"SPARQL - Results\"},\".gram\":{\"type\":\"application/srgs\",\"name\":\"Speech Recognition Grammar Specification\"},\".grxml\":{\"type\":\"application/srgs+xml\",\"name\":\"Speech Recognition Grammar Specification - XML\"},\".ssml\":{\"type\":\"application/ssml+xml\",\"name\":\"Speech Synthesis Markup Language\"},\".skp\":{\"type\":\"application/vnd.koan\",\"name\":\"SSEYO Koan Play File\"},\".sgml\":{\"type\":\"text/sgml\",\"name\":\"Standard Generalized Markup Language (SGML)\"},\".sdc\":{\"type\":\"application/vnd.stardivision.calc\",\"name\":\"StarOffice - Calc\"},\".sda\":{\"type\":\"application/vnd.stardivision.draw\",\"name\":\"StarOffice - Draw\"},\".sdd\":{\"type\":\"application/vnd.stardivision.impress\",\"name\":\"StarOffice - Impress\"},\".smf\":{\"type\":\"application/vnd.stardivision.math\",\"name\":\"StarOffice - Math\"},\".sdw\":{\"type\":\"application/vnd.stardivision.writer\",\"name\":\"StarOffice - Writer\"},\".sgl\":{\"type\":\"application/vnd.stardivision.writer-global\",\"name\":\"StarOffice - Writer (Global)\"},\".sm\":{\"type\":\"application/vnd.stepmania.stepchart\",\"name\":\"StepMania\"},\".sit\":{\"type\":\"application/x-stuffit\",\"name\":\"Stuffit Archive\"},\".sitx\":{\"type\":\"application/x-stuffitx\",\"name\":\"Stuffit Archive\"},\".sdkm\":{\"type\":\"application/vnd.solent.sdkm+xml\",\"name\":\"SudokuMagic\"},\".xo\":{\"type\":\"application/vnd.olpc-sugar\",\"name\":\"Sugar Linux Application Bundle\"},\".au\":{\"type\":\"audio/basic\",\"name\":\"Sun Audio - Au file format\"},\".wqd\":{\"type\":\"application/vnd.wqd\",\"name\":\"SundaHus WQ\"},\".sis\":{\"type\":\"application/vnd.symbian.install\",\"name\":\"Symbian Install Package\"},\".smi\":{\"type\":\"application/smil+xml\",\"name\":\"Synchronized Multimedia Integration Language\"},\".xsm\":{\"type\":\"application/vnd.syncml+xml\",\"name\":\"SyncML\"},\".bdm\":{\"type\":\"application/vnd.syncml.dm+wbxml\",\"name\":\"SyncML - Device Management\"},\".xdm\":{\"type\":\"application/vnd.syncml.dm+xml\",\"name\":\"SyncML - Device Management\"},\".sv4cpio\":{\"type\":\"application/x-sv4cpio\",\"name\":\"System V Release 4 CPIO Archive\"},\".sv4crc\":{\"type\":\"application/x-sv4crc\",\"name\":\"System V Release 4 CPIO Checksum Data\"},\".sbml\":{\"type\":\"application/sbml+xml\",\"name\":\"Systems Biology Markup Language\"},\".tsv\":{\"type\":\"text/tab-separated-values\",\"name\":\"Tab Seperated Values\"},\".tiff\":{\"type\":\"image/tiff\",\"name\":\"Tagged Image File Format\"},\".tao\":{\"type\":\"application/vnd.tao.intent-module-archive\",\"name\":\"Tao Intent\"},\".tar\":{\"type\":\"application/x-tar\",\"name\":\"Tar File (Tape Archive)\"},\".tcl\":{\"type\":\"application/x-tcl\",\"name\":\"Tcl Script\"},\".tex\":{\"type\":\"application/x-tex\",\"name\":\"TeX\"},\".tfm\":{\"type\":\"application/x-tex-tfm\",\"name\":\"TeX Font Metric\"},\".tei\":{\"type\":\"application/tei+xml\",\"name\":\"Text Encoding and Interchange\"},\".txt\":{\"type\":\"text/plain\",\"name\":\"Text File\"},\".dxp\":{\"type\":\"application/vnd.spotfire.dxp\",\"name\":\"TIBCO Spotfire\"},\".sfs\":{\"type\":\"application/vnd.spotfire.sfs\",\"name\":\"TIBCO Spotfire\"},\".tsd\":{\"type\":\"application/timestamped-data\",\"name\":\"Time Stamped Data Envelope\"},\".tpt\":{\"type\":\"application/vnd.trid.tpt\",\"name\":\"TRI Systems Config\"},\".mxs\":{\"type\":\"application/vnd.triscape.mxs\",\"name\":\"Triscape Map Explorer\"},\".t\":{\"type\":\"text/troff\",\"name\":\"troff\"},\".tra\":{\"type\":\"application/vnd.trueapp\",\"name\":\"True BASIC\"},\".ttf\":{\"type\":\"application/x-font-ttf\",\"name\":\"TrueType Font\"},\".ttl\":{\"type\":\"text/turtle\",\"name\":\"Turtle (Terse RDF Triple Language)\"},\".umj\":{\"type\":\"application/vnd.umajin\",\"name\":\"UMAJIN\"},\".uoml\":{\"type\":\"application/vnd.uoml+xml\",\"name\":\"Unique Object Markup Language\"},\".unityweb\":{\"type\":\"application/vnd.unity\",\"name\":\"Unity 3d\"},\".ufd\":{\"type\":\"application/vnd.ufdl\",\"name\":\"Universal Forms Description Language\"},\".uri\":{\"type\":\"text/uri-list\",\"name\":\"URI Resolution Services\"},\".utz\":{\"type\":\"application/vnd.uiq.theme\",\"name\":\"User Interface Quartz - Theme (Symbian)\"},\".ustar\":{\"type\":\"application/x-ustar\",\"name\":\"Ustar (Uniform Standard Tape Archive)\"},\".uu\":{\"type\":\"text/x-uuencode\",\"name\":\"UUEncode\"},\".vcs\":{\"type\":\"text/x-vcalendar\",\"name\":\"vCalendar\"},\".vcf\":{\"type\":\"text/x-vcard\",\"name\":\"vCard\"},\".vcd\":{\"type\":\"application/x-cdlink\",\"name\":\"Video CD\"},\".vsf\":{\"type\":\"application/vnd.vsf\",\"name\":\"Viewport+\"},\".wrl\":{\"type\":\"model/vrml\",\"name\":\"Virtual Reality Modeling Language\"},\".vcx\":{\"type\":\"application/vnd.vcx\",\"name\":\"VirtualCatalog\"},\".mts\":{\"type\":\"model/vnd.mts\",\"name\":\"Virtue MTS\"},\".vtu\":{\"type\":\"model/vnd.vtu\",\"name\":\"Virtue VTU\"},\".vis\":{\"type\":\"application/vnd.visionary\",\"name\":\"Visionary\"},\".viv\":{\"type\":\"video/vnd.vivo\",\"name\":\"Vivo\"},\".ccxml\":{\"type\":\"application/ccxml+xml,\",\"name\":\"Voice Browser Call Control\"},\".vxml\":{\"type\":\"application/voicexml+xml\",\"name\":\"VoiceXML\"},\".src\":{\"type\":\"application/x-wais-source\",\"name\":\"WAIS Source\"},\".wbxml\":{\"type\":\"application/vnd.wap.wbxml\",\"name\":\"WAP Binary XML (WBXML)\"},\".wbmp\":{\"type\":\"image/vnd.wap.wbmp\",\"name\":\"WAP Bitamp (WBMP)\"},\".wav\":{\"type\":\"audio/x-wav\",\"name\":\"Waveform Audio File Format (WAV)\"},\".davmount\":{\"type\":\"application/davmount+xml\",\"name\":\"Web Distributed Authoring and Versioning\"},\".woff\":{\"type\":\"application/x-font-woff\",\"name\":\"Web Open Font Format\"},\".wspolicy\":{\"type\":\"application/wspolicy+xml\",\"name\":\"Web Services Policy\"},\".webp\":{\"type\":\"image/webp\",\"name\":\"WebP Image\"},\".wtb\":{\"type\":\"application/vnd.webturbo\",\"name\":\"WebTurbo\"},\".wgt\":{\"type\":\"application/widget\",\"name\":\"Widget Packaging and XML Configuration\"},\".hlp\":{\"type\":\"application/winhlp\",\"name\":\"WinHelp\"},\".wml\":{\"type\":\"text/vnd.wap.wml\",\"name\":\"Wireless Markup Language (WML)\"},\".wmls\":{\"type\":\"text/vnd.wap.wmlscript\",\"name\":\"Wireless Markup Language Script (WMLScript)\"},\".wmlsc\":{\"type\":\"application/vnd.wap.wmlscriptc\",\"name\":\"WMLScript\"},\".wpd\":{\"type\":\"application/vnd.wordperfect\",\"name\":\"Wordperfect\"},\".stf\":{\"type\":\"application/vnd.wt.stf\",\"name\":\"Worldtalk\"},\".wsdl\":{\"type\":\"application/wsdl+xml\",\"name\":\"WSDL - Web Services Description Language\"},\".xbm\":{\"type\":\"image/x-xbitmap\",\"name\":\"X BitMap\"},\".xpm\":{\"type\":\"image/x-xpixmap\",\"name\":\"X PixMap\"},\".xwd\":{\"type\":\"image/x-xwindowdump\",\"name\":\"X Window Dump\"},\".der\":{\"type\":\"application/x-x509-ca-cert\",\"name\":\"X.509 Certificate\"},\".fig\":{\"type\":\"application/x-xfig\",\"name\":\"Xfig\"},\".xhtml\":{\"type\":\"application/xhtml+xml\",\"name\":\"XHTML - The Extensible HyperText Markup Language\"},\".xdf\":{\"type\":\"application/xcap-diff+xml\",\"name\":\"XML Configuration Access Protocol - XCAP Diff\"},\".xenc\":{\"type\":\"application/xenc+xml\",\"name\":\"XML Encryption Syntax and Processing\"},\".xer\":{\"type\":\"application/patch-ops-error+xml\",\"name\":\"XML Patch Framework\"},\".rl\":{\"type\":\"application/resource-lists+xml\",\"name\":\"XML Resource Lists\"},\".rs\":{\"type\":\"application/rls-services+xml\",\"name\":\"XML Resource Lists\"},\".rld\":{\"type\":\"application/resource-lists-diff+xml\",\"name\":\"XML Resource Lists Diff\"},\".xslt\":{\"type\":\"application/xslt+xml\",\"name\":\"XML Transformations\"},\".xop\":{\"type\":\"application/xop+xml\",\"name\":\"XML-Binary Optimized Packaging\"},\".xpi\":{\"type\":\"application/x-xpinstall\",\"name\":\"XPInstall - Mozilla\"},\".xspf\":{\"type\":\"application/xspf+xml\",\"name\":\"XSPF - XML Shareable Playlist Format\"},\".xul\":{\"type\":\"application/vnd.mozilla.xul+xml\",\"name\":\"XUL - XML User Interface Language\"},\".xyz\":{\"type\":\"chemical/x-xyz\",\"name\":\"XYZ File Format\"},\".yaml\":{\"type\":\"text/yaml\",\"name\":\"YAML Ain't Markup Language / Yet Another Markup Language\"},\".yang\":{\"type\":\"application/yang\",\"name\":\"YANG Data Modeling Language\"},\".yin\":{\"type\":\"application/yin+xml\",\"name\":\"YIN (YANG - XML)\"},\".zir\":{\"type\":\"application/vnd.zul\",\"name\":\"Z.U.L. Geometry\"},\".zip\":{\"type\":\"application/zip\",\"name\":\"Zip Archive\"},\".zmm\":{\"type\":\"application/vnd.handheld-entertainment+xml\",\"name\":\"ZVUE Media Manager\"},\".zaz\":{\"type\":\"application/vnd.zzazz.deck+xml\",\"name\":\"Zzazz Deck\"}}");

/***/ }),

/***/ "./node_modules/sortablejs/modular/sortable.esm.js":
/*!*********************************************************!*\
  !*** ./node_modules/sortablejs/modular/sortable.esm.js ***!
  \*********************************************************/
/*! exports provided: default, MultiDrag, Sortable, Swap */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MultiDrag", function() { return MultiDragPlugin; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Sortable", function() { return Sortable; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Swap", function() { return SwapPlugin; });
/**!
 * Sortable 1.13.0
 * @author	RubaXa   <trash@rubaxa.org>
 * @author	owenm    <owen23355@gmail.com>
 * @license MIT
 */
function _typeof(obj) {
  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    _typeof = function (obj) {
      return typeof obj;
    };
  } else {
    _typeof = function (obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

function _extends() {
  _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  return _extends.apply(this, arguments);
}

function _objectSpread(target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i] != null ? arguments[i] : {};
    var ownKeys = Object.keys(source);

    if (typeof Object.getOwnPropertySymbols === 'function') {
      ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) {
        return Object.getOwnPropertyDescriptor(source, sym).enumerable;
      }));
    }

    ownKeys.forEach(function (key) {
      _defineProperty(target, key, source[key]);
    });
  }

  return target;
}

function _objectWithoutPropertiesLoose(source, excluded) {
  if (source == null) return {};
  var target = {};
  var sourceKeys = Object.keys(source);
  var key, i;

  for (i = 0; i < sourceKeys.length; i++) {
    key = sourceKeys[i];
    if (excluded.indexOf(key) >= 0) continue;
    target[key] = source[key];
  }

  return target;
}

function _objectWithoutProperties(source, excluded) {
  if (source == null) return {};

  var target = _objectWithoutPropertiesLoose(source, excluded);

  var key, i;

  if (Object.getOwnPropertySymbols) {
    var sourceSymbolKeys = Object.getOwnPropertySymbols(source);

    for (i = 0; i < sourceSymbolKeys.length; i++) {
      key = sourceSymbolKeys[i];
      if (excluded.indexOf(key) >= 0) continue;
      if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue;
      target[key] = source[key];
    }
  }

  return target;
}

function _toConsumableArray(arr) {
  return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread();
}

function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) {
    for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) arr2[i] = arr[i];

    return arr2;
  }
}

function _iterableToArray(iter) {
  if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter);
}

function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance");
}

var version = "1.13.0";

function userAgent(pattern) {
  if (typeof window !== 'undefined' && window.navigator) {
    return !!
    /*@__PURE__*/
    navigator.userAgent.match(pattern);
  }
}

var IE11OrLess = userAgent(/(?:Trident.*rv[ :]?11\.|msie|iemobile|Windows Phone)/i);
var Edge = userAgent(/Edge/i);
var FireFox = userAgent(/firefox/i);
var Safari = userAgent(/safari/i) && !userAgent(/chrome/i) && !userAgent(/android/i);
var IOS = userAgent(/iP(ad|od|hone)/i);
var ChromeForAndroid = userAgent(/chrome/i) && userAgent(/android/i);

var captureMode = {
  capture: false,
  passive: false
};

function on(el, event, fn) {
  el.addEventListener(event, fn, !IE11OrLess && captureMode);
}

function off(el, event, fn) {
  el.removeEventListener(event, fn, !IE11OrLess && captureMode);
}

function matches(
/**HTMLElement*/
el,
/**String*/
selector) {
  if (!selector) return;
  selector[0] === '>' && (selector = selector.substring(1));

  if (el) {
    try {
      if (el.matches) {
        return el.matches(selector);
      } else if (el.msMatchesSelector) {
        return el.msMatchesSelector(selector);
      } else if (el.webkitMatchesSelector) {
        return el.webkitMatchesSelector(selector);
      }
    } catch (_) {
      return false;
    }
  }

  return false;
}

function getParentOrHost(el) {
  return el.host && el !== document && el.host.nodeType ? el.host : el.parentNode;
}

function closest(
/**HTMLElement*/
el,
/**String*/
selector,
/**HTMLElement*/
ctx, includeCTX) {
  if (el) {
    ctx = ctx || document;

    do {
      if (selector != null && (selector[0] === '>' ? el.parentNode === ctx && matches(el, selector) : matches(el, selector)) || includeCTX && el === ctx) {
        return el;
      }

      if (el === ctx) break;
      /* jshint boss:true */
    } while (el = getParentOrHost(el));
  }

  return null;
}

var R_SPACE = /\s+/g;

function toggleClass(el, name, state) {
  if (el && name) {
    if (el.classList) {
      el.classList[state ? 'add' : 'remove'](name);
    } else {
      var className = (' ' + el.className + ' ').replace(R_SPACE, ' ').replace(' ' + name + ' ', ' ');
      el.className = (className + (state ? ' ' + name : '')).replace(R_SPACE, ' ');
    }
  }
}

function css(el, prop, val) {
  var style = el && el.style;

  if (style) {
    if (val === void 0) {
      if (document.defaultView && document.defaultView.getComputedStyle) {
        val = document.defaultView.getComputedStyle(el, '');
      } else if (el.currentStyle) {
        val = el.currentStyle;
      }

      return prop === void 0 ? val : val[prop];
    } else {
      if (!(prop in style) && prop.indexOf('webkit') === -1) {
        prop = '-webkit-' + prop;
      }

      style[prop] = val + (typeof val === 'string' ? '' : 'px');
    }
  }
}

function matrix(el, selfOnly) {
  var appliedTransforms = '';

  if (typeof el === 'string') {
    appliedTransforms = el;
  } else {
    do {
      var transform = css(el, 'transform');

      if (transform && transform !== 'none') {
        appliedTransforms = transform + ' ' + appliedTransforms;
      }
      /* jshint boss:true */

    } while (!selfOnly && (el = el.parentNode));
  }

  var matrixFn = window.DOMMatrix || window.WebKitCSSMatrix || window.CSSMatrix || window.MSCSSMatrix;
  /*jshint -W056 */

  return matrixFn && new matrixFn(appliedTransforms);
}

function find(ctx, tagName, iterator) {
  if (ctx) {
    var list = ctx.getElementsByTagName(tagName),
        i = 0,
        n = list.length;

    if (iterator) {
      for (; i < n; i++) {
        iterator(list[i], i);
      }
    }

    return list;
  }

  return [];
}

function getWindowScrollingElement() {
  var scrollingElement = document.scrollingElement;

  if (scrollingElement) {
    return scrollingElement;
  } else {
    return document.documentElement;
  }
}
/**
 * Returns the "bounding client rect" of given element
 * @param  {HTMLElement} el                       The element whose boundingClientRect is wanted
 * @param  {[Boolean]} relativeToContainingBlock  Whether the rect should be relative to the containing block of (including) the container
 * @param  {[Boolean]} relativeToNonStaticParent  Whether the rect should be relative to the relative parent of (including) the contaienr
 * @param  {[Boolean]} undoScale                  Whether the container's scale() should be undone
 * @param  {[HTMLElement]} container              The parent the element will be placed in
 * @return {Object}                               The boundingClientRect of el, with specified adjustments
 */


function getRect(el, relativeToContainingBlock, relativeToNonStaticParent, undoScale, container) {
  if (!el.getBoundingClientRect && el !== window) return;
  var elRect, top, left, bottom, right, height, width;

  if (el !== window && el.parentNode && el !== getWindowScrollingElement()) {
    elRect = el.getBoundingClientRect();
    top = elRect.top;
    left = elRect.left;
    bottom = elRect.bottom;
    right = elRect.right;
    height = elRect.height;
    width = elRect.width;
  } else {
    top = 0;
    left = 0;
    bottom = window.innerHeight;
    right = window.innerWidth;
    height = window.innerHeight;
    width = window.innerWidth;
  }

  if ((relativeToContainingBlock || relativeToNonStaticParent) && el !== window) {
    // Adjust for translate()
    container = container || el.parentNode; // solves #1123 (see: https://stackoverflow.com/a/37953806/6088312)
    // Not needed on <= IE11

    if (!IE11OrLess) {
      do {
        if (container && container.getBoundingClientRect && (css(container, 'transform') !== 'none' || relativeToNonStaticParent && css(container, 'position') !== 'static')) {
          var containerRect = container.getBoundingClientRect(); // Set relative to edges of padding box of container

          top -= containerRect.top + parseInt(css(container, 'border-top-width'));
          left -= containerRect.left + parseInt(css(container, 'border-left-width'));
          bottom = top + elRect.height;
          right = left + elRect.width;
          break;
        }
        /* jshint boss:true */

      } while (container = container.parentNode);
    }
  }

  if (undoScale && el !== window) {
    // Adjust for scale()
    var elMatrix = matrix(container || el),
        scaleX = elMatrix && elMatrix.a,
        scaleY = elMatrix && elMatrix.d;

    if (elMatrix) {
      top /= scaleY;
      left /= scaleX;
      width /= scaleX;
      height /= scaleY;
      bottom = top + height;
      right = left + width;
    }
  }

  return {
    top: top,
    left: left,
    bottom: bottom,
    right: right,
    width: width,
    height: height
  };
}
/**
 * Checks if a side of an element is scrolled past a side of its parents
 * @param  {HTMLElement}  el           The element who's side being scrolled out of view is in question
 * @param  {String}       elSide       Side of the element in question ('top', 'left', 'right', 'bottom')
 * @param  {String}       parentSide   Side of the parent in question ('top', 'left', 'right', 'bottom')
 * @return {HTMLElement}               The parent scroll element that the el's side is scrolled past, or null if there is no such element
 */


function isScrolledPast(el, elSide, parentSide) {
  var parent = getParentAutoScrollElement(el, true),
      elSideVal = getRect(el)[elSide];
  /* jshint boss:true */

  while (parent) {
    var parentSideVal = getRect(parent)[parentSide],
        visible = void 0;

    if (parentSide === 'top' || parentSide === 'left') {
      visible = elSideVal >= parentSideVal;
    } else {
      visible = elSideVal <= parentSideVal;
    }

    if (!visible) return parent;
    if (parent === getWindowScrollingElement()) break;
    parent = getParentAutoScrollElement(parent, false);
  }

  return false;
}
/**
 * Gets nth child of el, ignoring hidden children, sortable's elements (does not ignore clone if it's visible)
 * and non-draggable elements
 * @param  {HTMLElement} el       The parent element
 * @param  {Number} childNum      The index of the child
 * @param  {Object} options       Parent Sortable's options
 * @return {HTMLElement}          The child at index childNum, or null if not found
 */


function getChild(el, childNum, options) {
  var currentChild = 0,
      i = 0,
      children = el.children;

  while (i < children.length) {
    if (children[i].style.display !== 'none' && children[i] !== Sortable.ghost && children[i] !== Sortable.dragged && closest(children[i], options.draggable, el, false)) {
      if (currentChild === childNum) {
        return children[i];
      }

      currentChild++;
    }

    i++;
  }

  return null;
}
/**
 * Gets the last child in the el, ignoring ghostEl or invisible elements (clones)
 * @param  {HTMLElement} el       Parent element
 * @param  {selector} selector    Any other elements that should be ignored
 * @return {HTMLElement}          The last child, ignoring ghostEl
 */


function lastChild(el, selector) {
  var last = el.lastElementChild;

  while (last && (last === Sortable.ghost || css(last, 'display') === 'none' || selector && !matches(last, selector))) {
    last = last.previousElementSibling;
  }

  return last || null;
}
/**
 * Returns the index of an element within its parent for a selected set of
 * elements
 * @param  {HTMLElement} el
 * @param  {selector} selector
 * @return {number}
 */


function index(el, selector) {
  var index = 0;

  if (!el || !el.parentNode) {
    return -1;
  }
  /* jshint boss:true */


  while (el = el.previousElementSibling) {
    if (el.nodeName.toUpperCase() !== 'TEMPLATE' && el !== Sortable.clone && (!selector || matches(el, selector))) {
      index++;
    }
  }

  return index;
}
/**
 * Returns the scroll offset of the given element, added with all the scroll offsets of parent elements.
 * The value is returned in real pixels.
 * @param  {HTMLElement} el
 * @return {Array}             Offsets in the format of [left, top]
 */


function getRelativeScrollOffset(el) {
  var offsetLeft = 0,
      offsetTop = 0,
      winScroller = getWindowScrollingElement();

  if (el) {
    do {
      var elMatrix = matrix(el),
          scaleX = elMatrix.a,
          scaleY = elMatrix.d;
      offsetLeft += el.scrollLeft * scaleX;
      offsetTop += el.scrollTop * scaleY;
    } while (el !== winScroller && (el = el.parentNode));
  }

  return [offsetLeft, offsetTop];
}
/**
 * Returns the index of the object within the given array
 * @param  {Array} arr   Array that may or may not hold the object
 * @param  {Object} obj  An object that has a key-value pair unique to and identical to a key-value pair in the object you want to find
 * @return {Number}      The index of the object in the array, or -1
 */


function indexOfObject(arr, obj) {
  for (var i in arr) {
    if (!arr.hasOwnProperty(i)) continue;

    for (var key in obj) {
      if (obj.hasOwnProperty(key) && obj[key] === arr[i][key]) return Number(i);
    }
  }

  return -1;
}

function getParentAutoScrollElement(el, includeSelf) {
  // skip to window
  if (!el || !el.getBoundingClientRect) return getWindowScrollingElement();
  var elem = el;
  var gotSelf = false;

  do {
    // we don't need to get elem css if it isn't even overflowing in the first place (performance)
    if (elem.clientWidth < elem.scrollWidth || elem.clientHeight < elem.scrollHeight) {
      var elemCSS = css(elem);

      if (elem.clientWidth < elem.scrollWidth && (elemCSS.overflowX == 'auto' || elemCSS.overflowX == 'scroll') || elem.clientHeight < elem.scrollHeight && (elemCSS.overflowY == 'auto' || elemCSS.overflowY == 'scroll')) {
        if (!elem.getBoundingClientRect || elem === document.body) return getWindowScrollingElement();
        if (gotSelf || includeSelf) return elem;
        gotSelf = true;
      }
    }
    /* jshint boss:true */

  } while (elem = elem.parentNode);

  return getWindowScrollingElement();
}

function extend(dst, src) {
  if (dst && src) {
    for (var key in src) {
      if (src.hasOwnProperty(key)) {
        dst[key] = src[key];
      }
    }
  }

  return dst;
}

function isRectEqual(rect1, rect2) {
  return Math.round(rect1.top) === Math.round(rect2.top) && Math.round(rect1.left) === Math.round(rect2.left) && Math.round(rect1.height) === Math.round(rect2.height) && Math.round(rect1.width) === Math.round(rect2.width);
}

var _throttleTimeout;

function throttle(callback, ms) {
  return function () {
    if (!_throttleTimeout) {
      var args = arguments,
          _this = this;

      if (args.length === 1) {
        callback.call(_this, args[0]);
      } else {
        callback.apply(_this, args);
      }

      _throttleTimeout = setTimeout(function () {
        _throttleTimeout = void 0;
      }, ms);
    }
  };
}

function cancelThrottle() {
  clearTimeout(_throttleTimeout);
  _throttleTimeout = void 0;
}

function scrollBy(el, x, y) {
  el.scrollLeft += x;
  el.scrollTop += y;
}

function clone(el) {
  var Polymer = window.Polymer;
  var $ = window.jQuery || window.Zepto;

  if (Polymer && Polymer.dom) {
    return Polymer.dom(el).cloneNode(true);
  } else if ($) {
    return $(el).clone(true)[0];
  } else {
    return el.cloneNode(true);
  }
}

function setRect(el, rect) {
  css(el, 'position', 'absolute');
  css(el, 'top', rect.top);
  css(el, 'left', rect.left);
  css(el, 'width', rect.width);
  css(el, 'height', rect.height);
}

function unsetRect(el) {
  css(el, 'position', '');
  css(el, 'top', '');
  css(el, 'left', '');
  css(el, 'width', '');
  css(el, 'height', '');
}

var expando = 'Sortable' + new Date().getTime();

function AnimationStateManager() {
  var animationStates = [],
      animationCallbackId;
  return {
    captureAnimationState: function captureAnimationState() {
      animationStates = [];
      if (!this.options.animation) return;
      var children = [].slice.call(this.el.children);
      children.forEach(function (child) {
        if (css(child, 'display') === 'none' || child === Sortable.ghost) return;
        animationStates.push({
          target: child,
          rect: getRect(child)
        });

        var fromRect = _objectSpread({}, animationStates[animationStates.length - 1].rect); // If animating: compensate for current animation


        if (child.thisAnimationDuration) {
          var childMatrix = matrix(child, true);

          if (childMatrix) {
            fromRect.top -= childMatrix.f;
            fromRect.left -= childMatrix.e;
          }
        }

        child.fromRect = fromRect;
      });
    },
    addAnimationState: function addAnimationState(state) {
      animationStates.push(state);
    },
    removeAnimationState: function removeAnimationState(target) {
      animationStates.splice(indexOfObject(animationStates, {
        target: target
      }), 1);
    },
    animateAll: function animateAll(callback) {
      var _this = this;

      if (!this.options.animation) {
        clearTimeout(animationCallbackId);
        if (typeof callback === 'function') callback();
        return;
      }

      var animating = false,
          animationTime = 0;
      animationStates.forEach(function (state) {
        var time = 0,
            target = state.target,
            fromRect = target.fromRect,
            toRect = getRect(target),
            prevFromRect = target.prevFromRect,
            prevToRect = target.prevToRect,
            animatingRect = state.rect,
            targetMatrix = matrix(target, true);

        if (targetMatrix) {
          // Compensate for current animation
          toRect.top -= targetMatrix.f;
          toRect.left -= targetMatrix.e;
        }

        target.toRect = toRect;

        if (target.thisAnimationDuration) {
          // Could also check if animatingRect is between fromRect and toRect
          if (isRectEqual(prevFromRect, toRect) && !isRectEqual(fromRect, toRect) && // Make sure animatingRect is on line between toRect & fromRect
          (animatingRect.top - toRect.top) / (animatingRect.left - toRect.left) === (fromRect.top - toRect.top) / (fromRect.left - toRect.left)) {
            // If returning to same place as started from animation and on same axis
            time = calculateRealTime(animatingRect, prevFromRect, prevToRect, _this.options);
          }
        } // if fromRect != toRect: animate


        if (!isRectEqual(toRect, fromRect)) {
          target.prevFromRect = fromRect;
          target.prevToRect = toRect;

          if (!time) {
            time = _this.options.animation;
          }

          _this.animate(target, animatingRect, toRect, time);
        }

        if (time) {
          animating = true;
          animationTime = Math.max(animationTime, time);
          clearTimeout(target.animationResetTimer);
          target.animationResetTimer = setTimeout(function () {
            target.animationTime = 0;
            target.prevFromRect = null;
            target.fromRect = null;
            target.prevToRect = null;
            target.thisAnimationDuration = null;
          }, time);
          target.thisAnimationDuration = time;
        }
      });
      clearTimeout(animationCallbackId);

      if (!animating) {
        if (typeof callback === 'function') callback();
      } else {
        animationCallbackId = setTimeout(function () {
          if (typeof callback === 'function') callback();
        }, animationTime);
      }

      animationStates = [];
    },
    animate: function animate(target, currentRect, toRect, duration) {
      if (duration) {
        css(target, 'transition', '');
        css(target, 'transform', '');
        var elMatrix = matrix(this.el),
            scaleX = elMatrix && elMatrix.a,
            scaleY = elMatrix && elMatrix.d,
            translateX = (currentRect.left - toRect.left) / (scaleX || 1),
            translateY = (currentRect.top - toRect.top) / (scaleY || 1);
        target.animatingX = !!translateX;
        target.animatingY = !!translateY;
        css(target, 'transform', 'translate3d(' + translateX + 'px,' + translateY + 'px,0)');
        this.forRepaintDummy = repaint(target); // repaint

        css(target, 'transition', 'transform ' + duration + 'ms' + (this.options.easing ? ' ' + this.options.easing : ''));
        css(target, 'transform', 'translate3d(0,0,0)');
        typeof target.animated === 'number' && clearTimeout(target.animated);
        target.animated = setTimeout(function () {
          css(target, 'transition', '');
          css(target, 'transform', '');
          target.animated = false;
          target.animatingX = false;
          target.animatingY = false;
        }, duration);
      }
    }
  };
}

function repaint(target) {
  return target.offsetWidth;
}

function calculateRealTime(animatingRect, fromRect, toRect, options) {
  return Math.sqrt(Math.pow(fromRect.top - animatingRect.top, 2) + Math.pow(fromRect.left - animatingRect.left, 2)) / Math.sqrt(Math.pow(fromRect.top - toRect.top, 2) + Math.pow(fromRect.left - toRect.left, 2)) * options.animation;
}

var plugins = [];
var defaults = {
  initializeByDefault: true
};
var PluginManager = {
  mount: function mount(plugin) {
    // Set default static properties
    for (var option in defaults) {
      if (defaults.hasOwnProperty(option) && !(option in plugin)) {
        plugin[option] = defaults[option];
      }
    }

    plugins.forEach(function (p) {
      if (p.pluginName === plugin.pluginName) {
        throw "Sortable: Cannot mount plugin ".concat(plugin.pluginName, " more than once");
      }
    });
    plugins.push(plugin);
  },
  pluginEvent: function pluginEvent(eventName, sortable, evt) {
    var _this = this;

    this.eventCanceled = false;

    evt.cancel = function () {
      _this.eventCanceled = true;
    };

    var eventNameGlobal = eventName + 'Global';
    plugins.forEach(function (plugin) {
      if (!sortable[plugin.pluginName]) return; // Fire global events if it exists in this sortable

      if (sortable[plugin.pluginName][eventNameGlobal]) {
        sortable[plugin.pluginName][eventNameGlobal](_objectSpread({
          sortable: sortable
        }, evt));
      } // Only fire plugin event if plugin is enabled in this sortable,
      // and plugin has event defined


      if (sortable.options[plugin.pluginName] && sortable[plugin.pluginName][eventName]) {
        sortable[plugin.pluginName][eventName](_objectSpread({
          sortable: sortable
        }, evt));
      }
    });
  },
  initializePlugins: function initializePlugins(sortable, el, defaults, options) {
    plugins.forEach(function (plugin) {
      var pluginName = plugin.pluginName;
      if (!sortable.options[pluginName] && !plugin.initializeByDefault) return;
      var initialized = new plugin(sortable, el, sortable.options);
      initialized.sortable = sortable;
      initialized.options = sortable.options;
      sortable[pluginName] = initialized; // Add default options from plugin

      _extends(defaults, initialized.defaults);
    });

    for (var option in sortable.options) {
      if (!sortable.options.hasOwnProperty(option)) continue;
      var modified = this.modifyOption(sortable, option, sortable.options[option]);

      if (typeof modified !== 'undefined') {
        sortable.options[option] = modified;
      }
    }
  },
  getEventProperties: function getEventProperties(name, sortable) {
    var eventProperties = {};
    plugins.forEach(function (plugin) {
      if (typeof plugin.eventProperties !== 'function') return;

      _extends(eventProperties, plugin.eventProperties.call(sortable[plugin.pluginName], name));
    });
    return eventProperties;
  },
  modifyOption: function modifyOption(sortable, name, value) {
    var modifiedValue;
    plugins.forEach(function (plugin) {
      // Plugin must exist on the Sortable
      if (!sortable[plugin.pluginName]) return; // If static option listener exists for this option, call in the context of the Sortable's instance of this plugin

      if (plugin.optionListeners && typeof plugin.optionListeners[name] === 'function') {
        modifiedValue = plugin.optionListeners[name].call(sortable[plugin.pluginName], value);
      }
    });
    return modifiedValue;
  }
};

function dispatchEvent(_ref) {
  var sortable = _ref.sortable,
      rootEl = _ref.rootEl,
      name = _ref.name,
      targetEl = _ref.targetEl,
      cloneEl = _ref.cloneEl,
      toEl = _ref.toEl,
      fromEl = _ref.fromEl,
      oldIndex = _ref.oldIndex,
      newIndex = _ref.newIndex,
      oldDraggableIndex = _ref.oldDraggableIndex,
      newDraggableIndex = _ref.newDraggableIndex,
      originalEvent = _ref.originalEvent,
      putSortable = _ref.putSortable,
      extraEventProperties = _ref.extraEventProperties;
  sortable = sortable || rootEl && rootEl[expando];
  if (!sortable) return;
  var evt,
      options = sortable.options,
      onName = 'on' + name.charAt(0).toUpperCase() + name.substr(1); // Support for new CustomEvent feature

  if (window.CustomEvent && !IE11OrLess && !Edge) {
    evt = new CustomEvent(name, {
      bubbles: true,
      cancelable: true
    });
  } else {
    evt = document.createEvent('Event');
    evt.initEvent(name, true, true);
  }

  evt.to = toEl || rootEl;
  evt.from = fromEl || rootEl;
  evt.item = targetEl || rootEl;
  evt.clone = cloneEl;
  evt.oldIndex = oldIndex;
  evt.newIndex = newIndex;
  evt.oldDraggableIndex = oldDraggableIndex;
  evt.newDraggableIndex = newDraggableIndex;
  evt.originalEvent = originalEvent;
  evt.pullMode = putSortable ? putSortable.lastPutMode : undefined;

  var allEventProperties = _objectSpread({}, extraEventProperties, PluginManager.getEventProperties(name, sortable));

  for (var option in allEventProperties) {
    evt[option] = allEventProperties[option];
  }

  if (rootEl) {
    rootEl.dispatchEvent(evt);
  }

  if (options[onName]) {
    options[onName].call(sortable, evt);
  }
}

var pluginEvent = function pluginEvent(eventName, sortable) {
  var _ref = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {},
      originalEvent = _ref.evt,
      data = _objectWithoutProperties(_ref, ["evt"]);

  PluginManager.pluginEvent.bind(Sortable)(eventName, sortable, _objectSpread({
    dragEl: dragEl,
    parentEl: parentEl,
    ghostEl: ghostEl,
    rootEl: rootEl,
    nextEl: nextEl,
    lastDownEl: lastDownEl,
    cloneEl: cloneEl,
    cloneHidden: cloneHidden,
    dragStarted: moved,
    putSortable: putSortable,
    activeSortable: Sortable.active,
    originalEvent: originalEvent,
    oldIndex: oldIndex,
    oldDraggableIndex: oldDraggableIndex,
    newIndex: newIndex,
    newDraggableIndex: newDraggableIndex,
    hideGhostForTarget: _hideGhostForTarget,
    unhideGhostForTarget: _unhideGhostForTarget,
    cloneNowHidden: function cloneNowHidden() {
      cloneHidden = true;
    },
    cloneNowShown: function cloneNowShown() {
      cloneHidden = false;
    },
    dispatchSortableEvent: function dispatchSortableEvent(name) {
      _dispatchEvent({
        sortable: sortable,
        name: name,
        originalEvent: originalEvent
      });
    }
  }, data));
};

function _dispatchEvent(info) {
  dispatchEvent(_objectSpread({
    putSortable: putSortable,
    cloneEl: cloneEl,
    targetEl: dragEl,
    rootEl: rootEl,
    oldIndex: oldIndex,
    oldDraggableIndex: oldDraggableIndex,
    newIndex: newIndex,
    newDraggableIndex: newDraggableIndex
  }, info));
}

var dragEl,
    parentEl,
    ghostEl,
    rootEl,
    nextEl,
    lastDownEl,
    cloneEl,
    cloneHidden,
    oldIndex,
    newIndex,
    oldDraggableIndex,
    newDraggableIndex,
    activeGroup,
    putSortable,
    awaitingDragStarted = false,
    ignoreNextClick = false,
    sortables = [],
    tapEvt,
    touchEvt,
    lastDx,
    lastDy,
    tapDistanceLeft,
    tapDistanceTop,
    moved,
    lastTarget,
    lastDirection,
    pastFirstInvertThresh = false,
    isCircumstantialInvert = false,
    targetMoveDistance,
    // For positioning ghost absolutely
ghostRelativeParent,
    ghostRelativeParentInitialScroll = [],
    // (left, top)
_silent = false,
    savedInputChecked = [];
/** @const */

var documentExists = typeof document !== 'undefined',
    PositionGhostAbsolutely = IOS,
    CSSFloatProperty = Edge || IE11OrLess ? 'cssFloat' : 'float',
    // This will not pass for IE9, because IE9 DnD only works on anchors
supportDraggable = documentExists && !ChromeForAndroid && !IOS && 'draggable' in document.createElement('div'),
    supportCssPointerEvents = function () {
  if (!documentExists) return; // false when <= IE11

  if (IE11OrLess) {
    return false;
  }

  var el = document.createElement('x');
  el.style.cssText = 'pointer-events:auto';
  return el.style.pointerEvents === 'auto';
}(),
    _detectDirection = function _detectDirection(el, options) {
  var elCSS = css(el),
      elWidth = parseInt(elCSS.width) - parseInt(elCSS.paddingLeft) - parseInt(elCSS.paddingRight) - parseInt(elCSS.borderLeftWidth) - parseInt(elCSS.borderRightWidth),
      child1 = getChild(el, 0, options),
      child2 = getChild(el, 1, options),
      firstChildCSS = child1 && css(child1),
      secondChildCSS = child2 && css(child2),
      firstChildWidth = firstChildCSS && parseInt(firstChildCSS.marginLeft) + parseInt(firstChildCSS.marginRight) + getRect(child1).width,
      secondChildWidth = secondChildCSS && parseInt(secondChildCSS.marginLeft) + parseInt(secondChildCSS.marginRight) + getRect(child2).width;

  if (elCSS.display === 'flex') {
    return elCSS.flexDirection === 'column' || elCSS.flexDirection === 'column-reverse' ? 'vertical' : 'horizontal';
  }

  if (elCSS.display === 'grid') {
    return elCSS.gridTemplateColumns.split(' ').length <= 1 ? 'vertical' : 'horizontal';
  }

  if (child1 && firstChildCSS["float"] && firstChildCSS["float"] !== 'none') {
    var touchingSideChild2 = firstChildCSS["float"] === 'left' ? 'left' : 'right';
    return child2 && (secondChildCSS.clear === 'both' || secondChildCSS.clear === touchingSideChild2) ? 'vertical' : 'horizontal';
  }

  return child1 && (firstChildCSS.display === 'block' || firstChildCSS.display === 'flex' || firstChildCSS.display === 'table' || firstChildCSS.display === 'grid' || firstChildWidth >= elWidth && elCSS[CSSFloatProperty] === 'none' || child2 && elCSS[CSSFloatProperty] === 'none' && firstChildWidth + secondChildWidth > elWidth) ? 'vertical' : 'horizontal';
},
    _dragElInRowColumn = function _dragElInRowColumn(dragRect, targetRect, vertical) {
  var dragElS1Opp = vertical ? dragRect.left : dragRect.top,
      dragElS2Opp = vertical ? dragRect.right : dragRect.bottom,
      dragElOppLength = vertical ? dragRect.width : dragRect.height,
      targetS1Opp = vertical ? targetRect.left : targetRect.top,
      targetS2Opp = vertical ? targetRect.right : targetRect.bottom,
      targetOppLength = vertical ? targetRect.width : targetRect.height;
  return dragElS1Opp === targetS1Opp || dragElS2Opp === targetS2Opp || dragElS1Opp + dragElOppLength / 2 === targetS1Opp + targetOppLength / 2;
},

/**
 * Detects first nearest empty sortable to X and Y position using emptyInsertThreshold.
 * @param  {Number} x      X position
 * @param  {Number} y      Y position
 * @return {HTMLElement}   Element of the first found nearest Sortable
 */
_detectNearestEmptySortable = function _detectNearestEmptySortable(x, y) {
  var ret;
  sortables.some(function (sortable) {
    if (lastChild(sortable)) return;
    var rect = getRect(sortable),
        threshold = sortable[expando].options.emptyInsertThreshold,
        insideHorizontally = x >= rect.left - threshold && x <= rect.right + threshold,
        insideVertically = y >= rect.top - threshold && y <= rect.bottom + threshold;

    if (threshold && insideHorizontally && insideVertically) {
      return ret = sortable;
    }
  });
  return ret;
},
    _prepareGroup = function _prepareGroup(options) {
  function toFn(value, pull) {
    return function (to, from, dragEl, evt) {
      var sameGroup = to.options.group.name && from.options.group.name && to.options.group.name === from.options.group.name;

      if (value == null && (pull || sameGroup)) {
        // Default pull value
        // Default pull and put value if same group
        return true;
      } else if (value == null || value === false) {
        return false;
      } else if (pull && value === 'clone') {
        return value;
      } else if (typeof value === 'function') {
        return toFn(value(to, from, dragEl, evt), pull)(to, from, dragEl, evt);
      } else {
        var otherGroup = (pull ? to : from).options.group.name;
        return value === true || typeof value === 'string' && value === otherGroup || value.join && value.indexOf(otherGroup) > -1;
      }
    };
  }

  var group = {};
  var originalGroup = options.group;

  if (!originalGroup || _typeof(originalGroup) != 'object') {
    originalGroup = {
      name: originalGroup
    };
  }

  group.name = originalGroup.name;
  group.checkPull = toFn(originalGroup.pull, true);
  group.checkPut = toFn(originalGroup.put);
  group.revertClone = originalGroup.revertClone;
  options.group = group;
},
    _hideGhostForTarget = function _hideGhostForTarget() {
  if (!supportCssPointerEvents && ghostEl) {
    css(ghostEl, 'display', 'none');
  }
},
    _unhideGhostForTarget = function _unhideGhostForTarget() {
  if (!supportCssPointerEvents && ghostEl) {
    css(ghostEl, 'display', '');
  }
}; // #1184 fix - Prevent click event on fallback if dragged but item not changed position


if (documentExists) {
  document.addEventListener('click', function (evt) {
    if (ignoreNextClick) {
      evt.preventDefault();
      evt.stopPropagation && evt.stopPropagation();
      evt.stopImmediatePropagation && evt.stopImmediatePropagation();
      ignoreNextClick = false;
      return false;
    }
  }, true);
}

var nearestEmptyInsertDetectEvent = function nearestEmptyInsertDetectEvent(evt) {
  if (dragEl) {
    evt = evt.touches ? evt.touches[0] : evt;

    var nearest = _detectNearestEmptySortable(evt.clientX, evt.clientY);

    if (nearest) {
      // Create imitation event
      var event = {};

      for (var i in evt) {
        if (evt.hasOwnProperty(i)) {
          event[i] = evt[i];
        }
      }

      event.target = event.rootEl = nearest;
      event.preventDefault = void 0;
      event.stopPropagation = void 0;

      nearest[expando]._onDragOver(event);
    }
  }
};

var _checkOutsideTargetEl = function _checkOutsideTargetEl(evt) {
  if (dragEl) {
    dragEl.parentNode[expando]._isOutsideThisEl(evt.target);
  }
};
/**
 * @class  Sortable
 * @param  {HTMLElement}  el
 * @param  {Object}       [options]
 */


function Sortable(el, options) {
  if (!(el && el.nodeType && el.nodeType === 1)) {
    throw "Sortable: `el` must be an HTMLElement, not ".concat({}.toString.call(el));
  }

  this.el = el; // root element

  this.options = options = _extends({}, options); // Export instance

  el[expando] = this;
  var defaults = {
    group: null,
    sort: true,
    disabled: false,
    store: null,
    handle: null,
    draggable: /^[uo]l$/i.test(el.nodeName) ? '>li' : '>*',
    swapThreshold: 1,
    // percentage; 0 <= x <= 1
    invertSwap: false,
    // invert always
    invertedSwapThreshold: null,
    // will be set to same as swapThreshold if default
    removeCloneOnHide: true,
    direction: function direction() {
      return _detectDirection(el, this.options);
    },
    ghostClass: 'sortable-ghost',
    chosenClass: 'sortable-chosen',
    dragClass: 'sortable-drag',
    ignore: 'a, img',
    filter: null,
    preventOnFilter: true,
    animation: 0,
    easing: null,
    setData: function setData(dataTransfer, dragEl) {
      dataTransfer.setData('Text', dragEl.textContent);
    },
    dropBubble: false,
    dragoverBubble: false,
    dataIdAttr: 'data-id',
    delay: 0,
    delayOnTouchOnly: false,
    touchStartThreshold: (Number.parseInt ? Number : window).parseInt(window.devicePixelRatio, 10) || 1,
    forceFallback: false,
    fallbackClass: 'sortable-fallback',
    fallbackOnBody: false,
    fallbackTolerance: 0,
    fallbackOffset: {
      x: 0,
      y: 0
    },
    supportPointer: Sortable.supportPointer !== false && 'PointerEvent' in window && !Safari,
    emptyInsertThreshold: 5
  };
  PluginManager.initializePlugins(this, el, defaults); // Set default options

  for (var name in defaults) {
    !(name in options) && (options[name] = defaults[name]);
  }

  _prepareGroup(options); // Bind all private methods


  for (var fn in this) {
    if (fn.charAt(0) === '_' && typeof this[fn] === 'function') {
      this[fn] = this[fn].bind(this);
    }
  } // Setup drag mode


  this.nativeDraggable = options.forceFallback ? false : supportDraggable;

  if (this.nativeDraggable) {
    // Touch start threshold cannot be greater than the native dragstart threshold
    this.options.touchStartThreshold = 1;
  } // Bind events


  if (options.supportPointer) {
    on(el, 'pointerdown', this._onTapStart);
  } else {
    on(el, 'mousedown', this._onTapStart);
    on(el, 'touchstart', this._onTapStart);
  }

  if (this.nativeDraggable) {
    on(el, 'dragover', this);
    on(el, 'dragenter', this);
  }

  sortables.push(this.el); // Restore sorting

  options.store && options.store.get && this.sort(options.store.get(this) || []); // Add animation state manager

  _extends(this, AnimationStateManager());
}

Sortable.prototype =
/** @lends Sortable.prototype */
{
  constructor: Sortable,
  _isOutsideThisEl: function _isOutsideThisEl(target) {
    if (!this.el.contains(target) && target !== this.el) {
      lastTarget = null;
    }
  },
  _getDirection: function _getDirection(evt, target) {
    return typeof this.options.direction === 'function' ? this.options.direction.call(this, evt, target, dragEl) : this.options.direction;
  },
  _onTapStart: function _onTapStart(
  /** Event|TouchEvent */
  evt) {
    if (!evt.cancelable) return;

    var _this = this,
        el = this.el,
        options = this.options,
        preventOnFilter = options.preventOnFilter,
        type = evt.type,
        touch = evt.touches && evt.touches[0] || evt.pointerType && evt.pointerType === 'touch' && evt,
        target = (touch || evt).target,
        originalTarget = evt.target.shadowRoot && (evt.path && evt.path[0] || evt.composedPath && evt.composedPath()[0]) || target,
        filter = options.filter;

    _saveInputCheckedState(el); // Don't trigger start event when an element is been dragged, otherwise the evt.oldindex always wrong when set option.group.


    if (dragEl) {
      return;
    }

    if (/mousedown|pointerdown/.test(type) && evt.button !== 0 || options.disabled) {
      return; // only left button and enabled
    } // cancel dnd if original target is content editable


    if (originalTarget.isContentEditable) {
      return;
    } // Safari ignores further event handling after mousedown


    if (!this.nativeDraggable && Safari && target && target.tagName.toUpperCase() === 'SELECT') {
      return;
    }

    target = closest(target, options.draggable, el, false);

    if (target && target.animated) {
      return;
    }

    if (lastDownEl === target) {
      // Ignoring duplicate `down`
      return;
    } // Get the index of the dragged element within its parent


    oldIndex = index(target);
    oldDraggableIndex = index(target, options.draggable); // Check filter

    if (typeof filter === 'function') {
      if (filter.call(this, evt, target, this)) {
        _dispatchEvent({
          sortable: _this,
          rootEl: originalTarget,
          name: 'filter',
          targetEl: target,
          toEl: el,
          fromEl: el
        });

        pluginEvent('filter', _this, {
          evt: evt
        });
        preventOnFilter && evt.cancelable && evt.preventDefault();
        return; // cancel dnd
      }
    } else if (filter) {
      filter = filter.split(',').some(function (criteria) {
        criteria = closest(originalTarget, criteria.trim(), el, false);

        if (criteria) {
          _dispatchEvent({
            sortable: _this,
            rootEl: criteria,
            name: 'filter',
            targetEl: target,
            fromEl: el,
            toEl: el
          });

          pluginEvent('filter', _this, {
            evt: evt
          });
          return true;
        }
      });

      if (filter) {
        preventOnFilter && evt.cancelable && evt.preventDefault();
        return; // cancel dnd
      }
    }

    if (options.handle && !closest(originalTarget, options.handle, el, false)) {
      return;
    } // Prepare `dragstart`


    this._prepareDragStart(evt, touch, target);
  },
  _prepareDragStart: function _prepareDragStart(
  /** Event */
  evt,
  /** Touch */
  touch,
  /** HTMLElement */
  target) {
    var _this = this,
        el = _this.el,
        options = _this.options,
        ownerDocument = el.ownerDocument,
        dragStartFn;

    if (target && !dragEl && target.parentNode === el) {
      var dragRect = getRect(target);
      rootEl = el;
      dragEl = target;
      parentEl = dragEl.parentNode;
      nextEl = dragEl.nextSibling;
      lastDownEl = target;
      activeGroup = options.group;
      Sortable.dragged = dragEl;
      tapEvt = {
        target: dragEl,
        clientX: (touch || evt).clientX,
        clientY: (touch || evt).clientY
      };
      tapDistanceLeft = tapEvt.clientX - dragRect.left;
      tapDistanceTop = tapEvt.clientY - dragRect.top;
      this._lastX = (touch || evt).clientX;
      this._lastY = (touch || evt).clientY;
      dragEl.style['will-change'] = 'all';

      dragStartFn = function dragStartFn() {
        pluginEvent('delayEnded', _this, {
          evt: evt
        });

        if (Sortable.eventCanceled) {
          _this._onDrop();

          return;
        } // Delayed drag has been triggered
        // we can re-enable the events: touchmove/mousemove


        _this._disableDelayedDragEvents();

        if (!FireFox && _this.nativeDraggable) {
          dragEl.draggable = true;
        } // Bind the events: dragstart/dragend


        _this._triggerDragStart(evt, touch); // Drag start event


        _dispatchEvent({
          sortable: _this,
          name: 'choose',
          originalEvent: evt
        }); // Chosen item


        toggleClass(dragEl, options.chosenClass, true);
      }; // Disable "draggable"


      options.ignore.split(',').forEach(function (criteria) {
        find(dragEl, criteria.trim(), _disableDraggable);
      });
      on(ownerDocument, 'dragover', nearestEmptyInsertDetectEvent);
      on(ownerDocument, 'mousemove', nearestEmptyInsertDetectEvent);
      on(ownerDocument, 'touchmove', nearestEmptyInsertDetectEvent);
      on(ownerDocument, 'mouseup', _this._onDrop);
      on(ownerDocument, 'touchend', _this._onDrop);
      on(ownerDocument, 'touchcancel', _this._onDrop); // Make dragEl draggable (must be before delay for FireFox)

      if (FireFox && this.nativeDraggable) {
        this.options.touchStartThreshold = 4;
        dragEl.draggable = true;
      }

      pluginEvent('delayStart', this, {
        evt: evt
      }); // Delay is impossible for native DnD in Edge or IE

      if (options.delay && (!options.delayOnTouchOnly || touch) && (!this.nativeDraggable || !(Edge || IE11OrLess))) {
        if (Sortable.eventCanceled) {
          this._onDrop();

          return;
        } // If the user moves the pointer or let go the click or touch
        // before the delay has been reached:
        // disable the delayed drag


        on(ownerDocument, 'mouseup', _this._disableDelayedDrag);
        on(ownerDocument, 'touchend', _this._disableDelayedDrag);
        on(ownerDocument, 'touchcancel', _this._disableDelayedDrag);
        on(ownerDocument, 'mousemove', _this._delayedDragTouchMoveHandler);
        on(ownerDocument, 'touchmove', _this._delayedDragTouchMoveHandler);
        options.supportPointer && on(ownerDocument, 'pointermove', _this._delayedDragTouchMoveHandler);
        _this._dragStartTimer = setTimeout(dragStartFn, options.delay);
      } else {
        dragStartFn();
      }
    }
  },
  _delayedDragTouchMoveHandler: function _delayedDragTouchMoveHandler(
  /** TouchEvent|PointerEvent **/
  e) {
    var touch = e.touches ? e.touches[0] : e;

    if (Math.max(Math.abs(touch.clientX - this._lastX), Math.abs(touch.clientY - this._lastY)) >= Math.floor(this.options.touchStartThreshold / (this.nativeDraggable && window.devicePixelRatio || 1))) {
      this._disableDelayedDrag();
    }
  },
  _disableDelayedDrag: function _disableDelayedDrag() {
    dragEl && _disableDraggable(dragEl);
    clearTimeout(this._dragStartTimer);

    this._disableDelayedDragEvents();
  },
  _disableDelayedDragEvents: function _disableDelayedDragEvents() {
    var ownerDocument = this.el.ownerDocument;
    off(ownerDocument, 'mouseup', this._disableDelayedDrag);
    off(ownerDocument, 'touchend', this._disableDelayedDrag);
    off(ownerDocument, 'touchcancel', this._disableDelayedDrag);
    off(ownerDocument, 'mousemove', this._delayedDragTouchMoveHandler);
    off(ownerDocument, 'touchmove', this._delayedDragTouchMoveHandler);
    off(ownerDocument, 'pointermove', this._delayedDragTouchMoveHandler);
  },
  _triggerDragStart: function _triggerDragStart(
  /** Event */
  evt,
  /** Touch */
  touch) {
    touch = touch || evt.pointerType == 'touch' && evt;

    if (!this.nativeDraggable || touch) {
      if (this.options.supportPointer) {
        on(document, 'pointermove', this._onTouchMove);
      } else if (touch) {
        on(document, 'touchmove', this._onTouchMove);
      } else {
        on(document, 'mousemove', this._onTouchMove);
      }
    } else {
      on(dragEl, 'dragend', this);
      on(rootEl, 'dragstart', this._onDragStart);
    }

    try {
      if (document.selection) {
        // Timeout neccessary for IE9
        _nextTick(function () {
          document.selection.empty();
        });
      } else {
        window.getSelection().removeAllRanges();
      }
    } catch (err) {}
  },
  _dragStarted: function _dragStarted(fallback, evt) {

    awaitingDragStarted = false;

    if (rootEl && dragEl) {
      pluginEvent('dragStarted', this, {
        evt: evt
      });

      if (this.nativeDraggable) {
        on(document, 'dragover', _checkOutsideTargetEl);
      }

      var options = this.options; // Apply effect

      !fallback && toggleClass(dragEl, options.dragClass, false);
      toggleClass(dragEl, options.ghostClass, true);
      Sortable.active = this;
      fallback && this._appendGhost(); // Drag start event

      _dispatchEvent({
        sortable: this,
        name: 'start',
        originalEvent: evt
      });
    } else {
      this._nulling();
    }
  },
  _emulateDragOver: function _emulateDragOver() {
    if (touchEvt) {
      this._lastX = touchEvt.clientX;
      this._lastY = touchEvt.clientY;

      _hideGhostForTarget();

      var target = document.elementFromPoint(touchEvt.clientX, touchEvt.clientY);
      var parent = target;

      while (target && target.shadowRoot) {
        target = target.shadowRoot.elementFromPoint(touchEvt.clientX, touchEvt.clientY);
        if (target === parent) break;
        parent = target;
      }

      dragEl.parentNode[expando]._isOutsideThisEl(target);

      if (parent) {
        do {
          if (parent[expando]) {
            var inserted = void 0;
            inserted = parent[expando]._onDragOver({
              clientX: touchEvt.clientX,
              clientY: touchEvt.clientY,
              target: target,
              rootEl: parent
            });

            if (inserted && !this.options.dragoverBubble) {
              break;
            }
          }

          target = parent; // store last element
        }
        /* jshint boss:true */
        while (parent = parent.parentNode);
      }

      _unhideGhostForTarget();
    }
  },
  _onTouchMove: function _onTouchMove(
  /**TouchEvent*/
  evt) {
    if (tapEvt) {
      var options = this.options,
          fallbackTolerance = options.fallbackTolerance,
          fallbackOffset = options.fallbackOffset,
          touch = evt.touches ? evt.touches[0] : evt,
          ghostMatrix = ghostEl && matrix(ghostEl, true),
          scaleX = ghostEl && ghostMatrix && ghostMatrix.a,
          scaleY = ghostEl && ghostMatrix && ghostMatrix.d,
          relativeScrollOffset = PositionGhostAbsolutely && ghostRelativeParent && getRelativeScrollOffset(ghostRelativeParent),
          dx = (touch.clientX - tapEvt.clientX + fallbackOffset.x) / (scaleX || 1) + (relativeScrollOffset ? relativeScrollOffset[0] - ghostRelativeParentInitialScroll[0] : 0) / (scaleX || 1),
          dy = (touch.clientY - tapEvt.clientY + fallbackOffset.y) / (scaleY || 1) + (relativeScrollOffset ? relativeScrollOffset[1] - ghostRelativeParentInitialScroll[1] : 0) / (scaleY || 1); // only set the status to dragging, when we are actually dragging

      if (!Sortable.active && !awaitingDragStarted) {
        if (fallbackTolerance && Math.max(Math.abs(touch.clientX - this._lastX), Math.abs(touch.clientY - this._lastY)) < fallbackTolerance) {
          return;
        }

        this._onDragStart(evt, true);
      }

      if (ghostEl) {
        if (ghostMatrix) {
          ghostMatrix.e += dx - (lastDx || 0);
          ghostMatrix.f += dy - (lastDy || 0);
        } else {
          ghostMatrix = {
            a: 1,
            b: 0,
            c: 0,
            d: 1,
            e: dx,
            f: dy
          };
        }

        var cssMatrix = "matrix(".concat(ghostMatrix.a, ",").concat(ghostMatrix.b, ",").concat(ghostMatrix.c, ",").concat(ghostMatrix.d, ",").concat(ghostMatrix.e, ",").concat(ghostMatrix.f, ")");
        css(ghostEl, 'webkitTransform', cssMatrix);
        css(ghostEl, 'mozTransform', cssMatrix);
        css(ghostEl, 'msTransform', cssMatrix);
        css(ghostEl, 'transform', cssMatrix);
        lastDx = dx;
        lastDy = dy;
        touchEvt = touch;
      }

      evt.cancelable && evt.preventDefault();
    }
  },
  _appendGhost: function _appendGhost() {
    // Bug if using scale(): https://stackoverflow.com/questions/2637058
    // Not being adjusted for
    if (!ghostEl) {
      var container = this.options.fallbackOnBody ? document.body : rootEl,
          rect = getRect(dragEl, true, PositionGhostAbsolutely, true, container),
          options = this.options; // Position absolutely

      if (PositionGhostAbsolutely) {
        // Get relatively positioned parent
        ghostRelativeParent = container;

        while (css(ghostRelativeParent, 'position') === 'static' && css(ghostRelativeParent, 'transform') === 'none' && ghostRelativeParent !== document) {
          ghostRelativeParent = ghostRelativeParent.parentNode;
        }

        if (ghostRelativeParent !== document.body && ghostRelativeParent !== document.documentElement) {
          if (ghostRelativeParent === document) ghostRelativeParent = getWindowScrollingElement();
          rect.top += ghostRelativeParent.scrollTop;
          rect.left += ghostRelativeParent.scrollLeft;
        } else {
          ghostRelativeParent = getWindowScrollingElement();
        }

        ghostRelativeParentInitialScroll = getRelativeScrollOffset(ghostRelativeParent);
      }

      ghostEl = dragEl.cloneNode(true);
      toggleClass(ghostEl, options.ghostClass, false);
      toggleClass(ghostEl, options.fallbackClass, true);
      toggleClass(ghostEl, options.dragClass, true);
      css(ghostEl, 'transition', '');
      css(ghostEl, 'transform', '');
      css(ghostEl, 'box-sizing', 'border-box');
      css(ghostEl, 'margin', 0);
      css(ghostEl, 'top', rect.top);
      css(ghostEl, 'left', rect.left);
      css(ghostEl, 'width', rect.width);
      css(ghostEl, 'height', rect.height);
      css(ghostEl, 'opacity', '0.8');
      css(ghostEl, 'position', PositionGhostAbsolutely ? 'absolute' : 'fixed');
      css(ghostEl, 'zIndex', '100000');
      css(ghostEl, 'pointerEvents', 'none');
      Sortable.ghost = ghostEl;
      container.appendChild(ghostEl); // Set transform-origin

      css(ghostEl, 'transform-origin', tapDistanceLeft / parseInt(ghostEl.style.width) * 100 + '% ' + tapDistanceTop / parseInt(ghostEl.style.height) * 100 + '%');
    }
  },
  _onDragStart: function _onDragStart(
  /**Event*/
  evt,
  /**boolean*/
  fallback) {
    var _this = this;

    var dataTransfer = evt.dataTransfer;
    var options = _this.options;
    pluginEvent('dragStart', this, {
      evt: evt
    });

    if (Sortable.eventCanceled) {
      this._onDrop();

      return;
    }

    pluginEvent('setupClone', this);

    if (!Sortable.eventCanceled) {
      cloneEl = clone(dragEl);
      cloneEl.draggable = false;
      cloneEl.style['will-change'] = '';

      this._hideClone();

      toggleClass(cloneEl, this.options.chosenClass, false);
      Sortable.clone = cloneEl;
    } // #1143: IFrame support workaround


    _this.cloneId = _nextTick(function () {
      pluginEvent('clone', _this);
      if (Sortable.eventCanceled) return;

      if (!_this.options.removeCloneOnHide) {
        rootEl.insertBefore(cloneEl, dragEl);
      }

      _this._hideClone();

      _dispatchEvent({
        sortable: _this,
        name: 'clone'
      });
    });
    !fallback && toggleClass(dragEl, options.dragClass, true); // Set proper drop events

    if (fallback) {
      ignoreNextClick = true;
      _this._loopId = setInterval(_this._emulateDragOver, 50);
    } else {
      // Undo what was set in _prepareDragStart before drag started
      off(document, 'mouseup', _this._onDrop);
      off(document, 'touchend', _this._onDrop);
      off(document, 'touchcancel', _this._onDrop);

      if (dataTransfer) {
        dataTransfer.effectAllowed = 'move';
        options.setData && options.setData.call(_this, dataTransfer, dragEl);
      }

      on(document, 'drop', _this); // #1276 fix:

      css(dragEl, 'transform', 'translateZ(0)');
    }

    awaitingDragStarted = true;
    _this._dragStartId = _nextTick(_this._dragStarted.bind(_this, fallback, evt));
    on(document, 'selectstart', _this);
    moved = true;

    if (Safari) {
      css(document.body, 'user-select', 'none');
    }
  },
  // Returns true - if no further action is needed (either inserted or another condition)
  _onDragOver: function _onDragOver(
  /**Event*/
  evt) {
    var el = this.el,
        target = evt.target,
        dragRect,
        targetRect,
        revert,
        options = this.options,
        group = options.group,
        activeSortable = Sortable.active,
        isOwner = activeGroup === group,
        canSort = options.sort,
        fromSortable = putSortable || activeSortable,
        vertical,
        _this = this,
        completedFired = false;

    if (_silent) return;

    function dragOverEvent(name, extra) {
      pluginEvent(name, _this, _objectSpread({
        evt: evt,
        isOwner: isOwner,
        axis: vertical ? 'vertical' : 'horizontal',
        revert: revert,
        dragRect: dragRect,
        targetRect: targetRect,
        canSort: canSort,
        fromSortable: fromSortable,
        target: target,
        completed: completed,
        onMove: function onMove(target, after) {
          return _onMove(rootEl, el, dragEl, dragRect, target, getRect(target), evt, after);
        },
        changed: changed
      }, extra));
    } // Capture animation state


    function capture() {
      dragOverEvent('dragOverAnimationCapture');

      _this.captureAnimationState();

      if (_this !== fromSortable) {
        fromSortable.captureAnimationState();
      }
    } // Return invocation when dragEl is inserted (or completed)


    function completed(insertion) {
      dragOverEvent('dragOverCompleted', {
        insertion: insertion
      });

      if (insertion) {
        // Clones must be hidden before folding animation to capture dragRectAbsolute properly
        if (isOwner) {
          activeSortable._hideClone();
        } else {
          activeSortable._showClone(_this);
        }

        if (_this !== fromSortable) {
          // Set ghost class to new sortable's ghost class
          toggleClass(dragEl, putSortable ? putSortable.options.ghostClass : activeSortable.options.ghostClass, false);
          toggleClass(dragEl, options.ghostClass, true);
        }

        if (putSortable !== _this && _this !== Sortable.active) {
          putSortable = _this;
        } else if (_this === Sortable.active && putSortable) {
          putSortable = null;
        } // Animation


        if (fromSortable === _this) {
          _this._ignoreWhileAnimating = target;
        }

        _this.animateAll(function () {
          dragOverEvent('dragOverAnimationComplete');
          _this._ignoreWhileAnimating = null;
        });

        if (_this !== fromSortable) {
          fromSortable.animateAll();
          fromSortable._ignoreWhileAnimating = null;
        }
      } // Null lastTarget if it is not inside a previously swapped element


      if (target === dragEl && !dragEl.animated || target === el && !target.animated) {
        lastTarget = null;
      } // no bubbling and not fallback


      if (!options.dragoverBubble && !evt.rootEl && target !== document) {
        dragEl.parentNode[expando]._isOutsideThisEl(evt.target); // Do not detect for empty insert if already inserted


        !insertion && nearestEmptyInsertDetectEvent(evt);
      }

      !options.dragoverBubble && evt.stopPropagation && evt.stopPropagation();
      return completedFired = true;
    } // Call when dragEl has been inserted


    function changed() {
      newIndex = index(dragEl);
      newDraggableIndex = index(dragEl, options.draggable);

      _dispatchEvent({
        sortable: _this,
        name: 'change',
        toEl: el,
        newIndex: newIndex,
        newDraggableIndex: newDraggableIndex,
        originalEvent: evt
      });
    }

    if (evt.preventDefault !== void 0) {
      evt.cancelable && evt.preventDefault();
    }

    target = closest(target, options.draggable, el, true);
    dragOverEvent('dragOver');
    if (Sortable.eventCanceled) return completedFired;

    if (dragEl.contains(evt.target) || target.animated && target.animatingX && target.animatingY || _this._ignoreWhileAnimating === target) {
      return completed(false);
    }

    ignoreNextClick = false;

    if (activeSortable && !options.disabled && (isOwner ? canSort || (revert = !rootEl.contains(dragEl)) // Reverting item into the original list
    : putSortable === this || (this.lastPutMode = activeGroup.checkPull(this, activeSortable, dragEl, evt)) && group.checkPut(this, activeSortable, dragEl, evt))) {
      vertical = this._getDirection(evt, target) === 'vertical';
      dragRect = getRect(dragEl);
      dragOverEvent('dragOverValid');
      if (Sortable.eventCanceled) return completedFired;

      if (revert) {
        parentEl = rootEl; // actualization

        capture();

        this._hideClone();

        dragOverEvent('revert');

        if (!Sortable.eventCanceled) {
          if (nextEl) {
            rootEl.insertBefore(dragEl, nextEl);
          } else {
            rootEl.appendChild(dragEl);
          }
        }

        return completed(true);
      }

      var elLastChild = lastChild(el, options.draggable);

      if (!elLastChild || _ghostIsLast(evt, vertical, this) && !elLastChild.animated) {
        // If already at end of list: Do not insert
        if (elLastChild === dragEl) {
          return completed(false);
        } // assign target only if condition is true


        if (elLastChild && el === evt.target) {
          target = elLastChild;
        }

        if (target) {
          targetRect = getRect(target);
        }

        if (_onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt, !!target) !== false) {
          capture();
          el.appendChild(dragEl);
          parentEl = el; // actualization

          changed();
          return completed(true);
        }
      } else if (target.parentNode === el) {
        targetRect = getRect(target);
        var direction = 0,
            targetBeforeFirstSwap,
            differentLevel = dragEl.parentNode !== el,
            differentRowCol = !_dragElInRowColumn(dragEl.animated && dragEl.toRect || dragRect, target.animated && target.toRect || targetRect, vertical),
            side1 = vertical ? 'top' : 'left',
            scrolledPastTop = isScrolledPast(target, 'top', 'top') || isScrolledPast(dragEl, 'top', 'top'),
            scrollBefore = scrolledPastTop ? scrolledPastTop.scrollTop : void 0;

        if (lastTarget !== target) {
          targetBeforeFirstSwap = targetRect[side1];
          pastFirstInvertThresh = false;
          isCircumstantialInvert = !differentRowCol && options.invertSwap || differentLevel;
        }

        direction = _getSwapDirection(evt, target, targetRect, vertical, differentRowCol ? 1 : options.swapThreshold, options.invertedSwapThreshold == null ? options.swapThreshold : options.invertedSwapThreshold, isCircumstantialInvert, lastTarget === target);
        var sibling;

        if (direction !== 0) {
          // Check if target is beside dragEl in respective direction (ignoring hidden elements)
          var dragIndex = index(dragEl);

          do {
            dragIndex -= direction;
            sibling = parentEl.children[dragIndex];
          } while (sibling && (css(sibling, 'display') === 'none' || sibling === ghostEl));
        } // If dragEl is already beside target: Do not insert


        if (direction === 0 || sibling === target) {
          return completed(false);
        }

        lastTarget = target;
        lastDirection = direction;
        var nextSibling = target.nextElementSibling,
            after = false;
        after = direction === 1;

        var moveVector = _onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt, after);

        if (moveVector !== false) {
          if (moveVector === 1 || moveVector === -1) {
            after = moveVector === 1;
          }

          _silent = true;
          setTimeout(_unsilent, 30);
          capture();

          if (after && !nextSibling) {
            el.appendChild(dragEl);
          } else {
            target.parentNode.insertBefore(dragEl, after ? nextSibling : target);
          } // Undo chrome's scroll adjustment (has no effect on other browsers)


          if (scrolledPastTop) {
            scrollBy(scrolledPastTop, 0, scrollBefore - scrolledPastTop.scrollTop);
          }

          parentEl = dragEl.parentNode; // actualization
          // must be done before animation

          if (targetBeforeFirstSwap !== undefined && !isCircumstantialInvert) {
            targetMoveDistance = Math.abs(targetBeforeFirstSwap - getRect(target)[side1]);
          }

          changed();
          return completed(true);
        }
      }

      if (el.contains(dragEl)) {
        return completed(false);
      }
    }

    return false;
  },
  _ignoreWhileAnimating: null,
  _offMoveEvents: function _offMoveEvents() {
    off(document, 'mousemove', this._onTouchMove);
    off(document, 'touchmove', this._onTouchMove);
    off(document, 'pointermove', this._onTouchMove);
    off(document, 'dragover', nearestEmptyInsertDetectEvent);
    off(document, 'mousemove', nearestEmptyInsertDetectEvent);
    off(document, 'touchmove', nearestEmptyInsertDetectEvent);
  },
  _offUpEvents: function _offUpEvents() {
    var ownerDocument = this.el.ownerDocument;
    off(ownerDocument, 'mouseup', this._onDrop);
    off(ownerDocument, 'touchend', this._onDrop);
    off(ownerDocument, 'pointerup', this._onDrop);
    off(ownerDocument, 'touchcancel', this._onDrop);
    off(document, 'selectstart', this);
  },
  _onDrop: function _onDrop(
  /**Event*/
  evt) {
    var el = this.el,
        options = this.options; // Get the index of the dragged element within its parent

    newIndex = index(dragEl);
    newDraggableIndex = index(dragEl, options.draggable);
    pluginEvent('drop', this, {
      evt: evt
    });
    parentEl = dragEl && dragEl.parentNode; // Get again after plugin event

    newIndex = index(dragEl);
    newDraggableIndex = index(dragEl, options.draggable);

    if (Sortable.eventCanceled) {
      this._nulling();

      return;
    }

    awaitingDragStarted = false;
    isCircumstantialInvert = false;
    pastFirstInvertThresh = false;
    clearInterval(this._loopId);
    clearTimeout(this._dragStartTimer);

    _cancelNextTick(this.cloneId);

    _cancelNextTick(this._dragStartId); // Unbind events


    if (this.nativeDraggable) {
      off(document, 'drop', this);
      off(el, 'dragstart', this._onDragStart);
    }

    this._offMoveEvents();

    this._offUpEvents();

    if (Safari) {
      css(document.body, 'user-select', '');
    }

    css(dragEl, 'transform', '');

    if (evt) {
      if (moved) {
        evt.cancelable && evt.preventDefault();
        !options.dropBubble && evt.stopPropagation();
      }

      ghostEl && ghostEl.parentNode && ghostEl.parentNode.removeChild(ghostEl);

      if (rootEl === parentEl || putSortable && putSortable.lastPutMode !== 'clone') {
        // Remove clone(s)
        cloneEl && cloneEl.parentNode && cloneEl.parentNode.removeChild(cloneEl);
      }

      if (dragEl) {
        if (this.nativeDraggable) {
          off(dragEl, 'dragend', this);
        }

        _disableDraggable(dragEl);

        dragEl.style['will-change'] = ''; // Remove classes
        // ghostClass is added in dragStarted

        if (moved && !awaitingDragStarted) {
          toggleClass(dragEl, putSortable ? putSortable.options.ghostClass : this.options.ghostClass, false);
        }

        toggleClass(dragEl, this.options.chosenClass, false); // Drag stop event

        _dispatchEvent({
          sortable: this,
          name: 'unchoose',
          toEl: parentEl,
          newIndex: null,
          newDraggableIndex: null,
          originalEvent: evt
        });

        if (rootEl !== parentEl) {
          if (newIndex >= 0) {
            // Add event
            _dispatchEvent({
              rootEl: parentEl,
              name: 'add',
              toEl: parentEl,
              fromEl: rootEl,
              originalEvent: evt
            }); // Remove event


            _dispatchEvent({
              sortable: this,
              name: 'remove',
              toEl: parentEl,
              originalEvent: evt
            }); // drag from one list and drop into another


            _dispatchEvent({
              rootEl: parentEl,
              name: 'sort',
              toEl: parentEl,
              fromEl: rootEl,
              originalEvent: evt
            });

            _dispatchEvent({
              sortable: this,
              name: 'sort',
              toEl: parentEl,
              originalEvent: evt
            });
          }

          putSortable && putSortable.save();
        } else {
          if (newIndex !== oldIndex) {
            if (newIndex >= 0) {
              // drag & drop within the same list
              _dispatchEvent({
                sortable: this,
                name: 'update',
                toEl: parentEl,
                originalEvent: evt
              });

              _dispatchEvent({
                sortable: this,
                name: 'sort',
                toEl: parentEl,
                originalEvent: evt
              });
            }
          }
        }

        if (Sortable.active) {
          /* jshint eqnull:true */
          if (newIndex == null || newIndex === -1) {
            newIndex = oldIndex;
            newDraggableIndex = oldDraggableIndex;
          }

          _dispatchEvent({
            sortable: this,
            name: 'end',
            toEl: parentEl,
            originalEvent: evt
          }); // Save sorting


          this.save();
        }
      }
    }

    this._nulling();
  },
  _nulling: function _nulling() {
    pluginEvent('nulling', this);
    rootEl = dragEl = parentEl = ghostEl = nextEl = cloneEl = lastDownEl = cloneHidden = tapEvt = touchEvt = moved = newIndex = newDraggableIndex = oldIndex = oldDraggableIndex = lastTarget = lastDirection = putSortable = activeGroup = Sortable.dragged = Sortable.ghost = Sortable.clone = Sortable.active = null;
    savedInputChecked.forEach(function (el) {
      el.checked = true;
    });
    savedInputChecked.length = lastDx = lastDy = 0;
  },
  handleEvent: function handleEvent(
  /**Event*/
  evt) {
    switch (evt.type) {
      case 'drop':
      case 'dragend':
        this._onDrop(evt);

        break;

      case 'dragenter':
      case 'dragover':
        if (dragEl) {
          this._onDragOver(evt);

          _globalDragOver(evt);
        }

        break;

      case 'selectstart':
        evt.preventDefault();
        break;
    }
  },

  /**
   * Serializes the item into an array of string.
   * @returns {String[]}
   */
  toArray: function toArray() {
    var order = [],
        el,
        children = this.el.children,
        i = 0,
        n = children.length,
        options = this.options;

    for (; i < n; i++) {
      el = children[i];

      if (closest(el, options.draggable, this.el, false)) {
        order.push(el.getAttribute(options.dataIdAttr) || _generateId(el));
      }
    }

    return order;
  },

  /**
   * Sorts the elements according to the array.
   * @param  {String[]}  order  order of the items
   */
  sort: function sort(order, useAnimation) {
    var items = {},
        rootEl = this.el;
    this.toArray().forEach(function (id, i) {
      var el = rootEl.children[i];

      if (closest(el, this.options.draggable, rootEl, false)) {
        items[id] = el;
      }
    }, this);
    useAnimation && this.captureAnimationState();
    order.forEach(function (id) {
      if (items[id]) {
        rootEl.removeChild(items[id]);
        rootEl.appendChild(items[id]);
      }
    });
    useAnimation && this.animateAll();
  },

  /**
   * Save the current sorting
   */
  save: function save() {
    var store = this.options.store;
    store && store.set && store.set(this);
  },

  /**
   * For each element in the set, get the first element that matches the selector by testing the element itself and traversing up through its ancestors in the DOM tree.
   * @param   {HTMLElement}  el
   * @param   {String}       [selector]  default: `options.draggable`
   * @returns {HTMLElement|null}
   */
  closest: function closest$1(el, selector) {
    return closest(el, selector || this.options.draggable, this.el, false);
  },

  /**
   * Set/get option
   * @param   {string} name
   * @param   {*}      [value]
   * @returns {*}
   */
  option: function option(name, value) {
    var options = this.options;

    if (value === void 0) {
      return options[name];
    } else {
      var modifiedValue = PluginManager.modifyOption(this, name, value);

      if (typeof modifiedValue !== 'undefined') {
        options[name] = modifiedValue;
      } else {
        options[name] = value;
      }

      if (name === 'group') {
        _prepareGroup(options);
      }
    }
  },

  /**
   * Destroy
   */
  destroy: function destroy() {
    pluginEvent('destroy', this);
    var el = this.el;
    el[expando] = null;
    off(el, 'mousedown', this._onTapStart);
    off(el, 'touchstart', this._onTapStart);
    off(el, 'pointerdown', this._onTapStart);

    if (this.nativeDraggable) {
      off(el, 'dragover', this);
      off(el, 'dragenter', this);
    } // Remove draggable attributes


    Array.prototype.forEach.call(el.querySelectorAll('[draggable]'), function (el) {
      el.removeAttribute('draggable');
    });

    this._onDrop();

    this._disableDelayedDragEvents();

    sortables.splice(sortables.indexOf(this.el), 1);
    this.el = el = null;
  },
  _hideClone: function _hideClone() {
    if (!cloneHidden) {
      pluginEvent('hideClone', this);
      if (Sortable.eventCanceled) return;
      css(cloneEl, 'display', 'none');

      if (this.options.removeCloneOnHide && cloneEl.parentNode) {
        cloneEl.parentNode.removeChild(cloneEl);
      }

      cloneHidden = true;
    }
  },
  _showClone: function _showClone(putSortable) {
    if (putSortable.lastPutMode !== 'clone') {
      this._hideClone();

      return;
    }

    if (cloneHidden) {
      pluginEvent('showClone', this);
      if (Sortable.eventCanceled) return; // show clone at dragEl or original position

      if (dragEl.parentNode == rootEl && !this.options.group.revertClone) {
        rootEl.insertBefore(cloneEl, dragEl);
      } else if (nextEl) {
        rootEl.insertBefore(cloneEl, nextEl);
      } else {
        rootEl.appendChild(cloneEl);
      }

      if (this.options.group.revertClone) {
        this.animate(dragEl, cloneEl);
      }

      css(cloneEl, 'display', '');
      cloneHidden = false;
    }
  }
};

function _globalDragOver(
/**Event*/
evt) {
  if (evt.dataTransfer) {
    evt.dataTransfer.dropEffect = 'move';
  }

  evt.cancelable && evt.preventDefault();
}

function _onMove(fromEl, toEl, dragEl, dragRect, targetEl, targetRect, originalEvent, willInsertAfter) {
  var evt,
      sortable = fromEl[expando],
      onMoveFn = sortable.options.onMove,
      retVal; // Support for new CustomEvent feature

  if (window.CustomEvent && !IE11OrLess && !Edge) {
    evt = new CustomEvent('move', {
      bubbles: true,
      cancelable: true
    });
  } else {
    evt = document.createEvent('Event');
    evt.initEvent('move', true, true);
  }

  evt.to = toEl;
  evt.from = fromEl;
  evt.dragged = dragEl;
  evt.draggedRect = dragRect;
  evt.related = targetEl || toEl;
  evt.relatedRect = targetRect || getRect(toEl);
  evt.willInsertAfter = willInsertAfter;
  evt.originalEvent = originalEvent;
  fromEl.dispatchEvent(evt);

  if (onMoveFn) {
    retVal = onMoveFn.call(sortable, evt, originalEvent);
  }

  return retVal;
}

function _disableDraggable(el) {
  el.draggable = false;
}

function _unsilent() {
  _silent = false;
}

function _ghostIsLast(evt, vertical, sortable) {
  var rect = getRect(lastChild(sortable.el, sortable.options.draggable));
  var spacer = 10;
  return vertical ? evt.clientX > rect.right + spacer || evt.clientX <= rect.right && evt.clientY > rect.bottom && evt.clientX >= rect.left : evt.clientX > rect.right && evt.clientY > rect.top || evt.clientX <= rect.right && evt.clientY > rect.bottom + spacer;
}

function _getSwapDirection(evt, target, targetRect, vertical, swapThreshold, invertedSwapThreshold, invertSwap, isLastTarget) {
  var mouseOnAxis = vertical ? evt.clientY : evt.clientX,
      targetLength = vertical ? targetRect.height : targetRect.width,
      targetS1 = vertical ? targetRect.top : targetRect.left,
      targetS2 = vertical ? targetRect.bottom : targetRect.right,
      invert = false;

  if (!invertSwap) {
    // Never invert or create dragEl shadow when target movemenet causes mouse to move past the end of regular swapThreshold
    if (isLastTarget && targetMoveDistance < targetLength * swapThreshold) {
      // multiplied only by swapThreshold because mouse will already be inside target by (1 - threshold) * targetLength / 2
      // check if past first invert threshold on side opposite of lastDirection
      if (!pastFirstInvertThresh && (lastDirection === 1 ? mouseOnAxis > targetS1 + targetLength * invertedSwapThreshold / 2 : mouseOnAxis < targetS2 - targetLength * invertedSwapThreshold / 2)) {
        // past first invert threshold, do not restrict inverted threshold to dragEl shadow
        pastFirstInvertThresh = true;
      }

      if (!pastFirstInvertThresh) {
        // dragEl shadow (target move distance shadow)
        if (lastDirection === 1 ? mouseOnAxis < targetS1 + targetMoveDistance // over dragEl shadow
        : mouseOnAxis > targetS2 - targetMoveDistance) {
          return -lastDirection;
        }
      } else {
        invert = true;
      }
    } else {
      // Regular
      if (mouseOnAxis > targetS1 + targetLength * (1 - swapThreshold) / 2 && mouseOnAxis < targetS2 - targetLength * (1 - swapThreshold) / 2) {
        return _getInsertDirection(target);
      }
    }
  }

  invert = invert || invertSwap;

  if (invert) {
    // Invert of regular
    if (mouseOnAxis < targetS1 + targetLength * invertedSwapThreshold / 2 || mouseOnAxis > targetS2 - targetLength * invertedSwapThreshold / 2) {
      return mouseOnAxis > targetS1 + targetLength / 2 ? 1 : -1;
    }
  }

  return 0;
}
/**
 * Gets the direction dragEl must be swapped relative to target in order to make it
 * seem that dragEl has been "inserted" into that element's position
 * @param  {HTMLElement} target       The target whose position dragEl is being inserted at
 * @return {Number}                   Direction dragEl must be swapped
 */


function _getInsertDirection(target) {
  if (index(dragEl) < index(target)) {
    return 1;
  } else {
    return -1;
  }
}
/**
 * Generate id
 * @param   {HTMLElement} el
 * @returns {String}
 * @private
 */


function _generateId(el) {
  var str = el.tagName + el.className + el.src + el.href + el.textContent,
      i = str.length,
      sum = 0;

  while (i--) {
    sum += str.charCodeAt(i);
  }

  return sum.toString(36);
}

function _saveInputCheckedState(root) {
  savedInputChecked.length = 0;
  var inputs = root.getElementsByTagName('input');
  var idx = inputs.length;

  while (idx--) {
    var el = inputs[idx];
    el.checked && savedInputChecked.push(el);
  }
}

function _nextTick(fn) {
  return setTimeout(fn, 0);
}

function _cancelNextTick(id) {
  return clearTimeout(id);
} // Fixed #973:


if (documentExists) {
  on(document, 'touchmove', function (evt) {
    if ((Sortable.active || awaitingDragStarted) && evt.cancelable) {
      evt.preventDefault();
    }
  });
} // Export utils


Sortable.utils = {
  on: on,
  off: off,
  css: css,
  find: find,
  is: function is(el, selector) {
    return !!closest(el, selector, el, false);
  },
  extend: extend,
  throttle: throttle,
  closest: closest,
  toggleClass: toggleClass,
  clone: clone,
  index: index,
  nextTick: _nextTick,
  cancelNextTick: _cancelNextTick,
  detectDirection: _detectDirection,
  getChild: getChild
};
/**
 * Get the Sortable instance of an element
 * @param  {HTMLElement} element The element
 * @return {Sortable|undefined}         The instance of Sortable
 */

Sortable.get = function (element) {
  return element[expando];
};
/**
 * Mount a plugin to Sortable
 * @param  {...SortablePlugin|SortablePlugin[]} plugins       Plugins being mounted
 */


Sortable.mount = function () {
  for (var _len = arguments.length, plugins = new Array(_len), _key = 0; _key < _len; _key++) {
    plugins[_key] = arguments[_key];
  }

  if (plugins[0].constructor === Array) plugins = plugins[0];
  plugins.forEach(function (plugin) {
    if (!plugin.prototype || !plugin.prototype.constructor) {
      throw "Sortable: Mounted plugin must be a constructor function, not ".concat({}.toString.call(plugin));
    }

    if (plugin.utils) Sortable.utils = _objectSpread({}, Sortable.utils, plugin.utils);
    PluginManager.mount(plugin);
  });
};
/**
 * Create sortable instance
 * @param {HTMLElement}  el
 * @param {Object}      [options]
 */


Sortable.create = function (el, options) {
  return new Sortable(el, options);
}; // Export


Sortable.version = version;

var autoScrolls = [],
    scrollEl,
    scrollRootEl,
    scrolling = false,
    lastAutoScrollX,
    lastAutoScrollY,
    touchEvt$1,
    pointerElemChangedInterval;

function AutoScrollPlugin() {
  function AutoScroll() {
    this.defaults = {
      scroll: true,
      scrollSensitivity: 30,
      scrollSpeed: 10,
      bubbleScroll: true
    }; // Bind all private methods

    for (var fn in this) {
      if (fn.charAt(0) === '_' && typeof this[fn] === 'function') {
        this[fn] = this[fn].bind(this);
      }
    }
  }

  AutoScroll.prototype = {
    dragStarted: function dragStarted(_ref) {
      var originalEvent = _ref.originalEvent;

      if (this.sortable.nativeDraggable) {
        on(document, 'dragover', this._handleAutoScroll);
      } else {
        if (this.options.supportPointer) {
          on(document, 'pointermove', this._handleFallbackAutoScroll);
        } else if (originalEvent.touches) {
          on(document, 'touchmove', this._handleFallbackAutoScroll);
        } else {
          on(document, 'mousemove', this._handleFallbackAutoScroll);
        }
      }
    },
    dragOverCompleted: function dragOverCompleted(_ref2) {
      var originalEvent = _ref2.originalEvent;

      // For when bubbling is canceled and using fallback (fallback 'touchmove' always reached)
      if (!this.options.dragOverBubble && !originalEvent.rootEl) {
        this._handleAutoScroll(originalEvent);
      }
    },
    drop: function drop() {
      if (this.sortable.nativeDraggable) {
        off(document, 'dragover', this._handleAutoScroll);
      } else {
        off(document, 'pointermove', this._handleFallbackAutoScroll);
        off(document, 'touchmove', this._handleFallbackAutoScroll);
        off(document, 'mousemove', this._handleFallbackAutoScroll);
      }

      clearPointerElemChangedInterval();
      clearAutoScrolls();
      cancelThrottle();
    },
    nulling: function nulling() {
      touchEvt$1 = scrollRootEl = scrollEl = scrolling = pointerElemChangedInterval = lastAutoScrollX = lastAutoScrollY = null;
      autoScrolls.length = 0;
    },
    _handleFallbackAutoScroll: function _handleFallbackAutoScroll(evt) {
      this._handleAutoScroll(evt, true);
    },
    _handleAutoScroll: function _handleAutoScroll(evt, fallback) {
      var _this = this;

      var x = (evt.touches ? evt.touches[0] : evt).clientX,
          y = (evt.touches ? evt.touches[0] : evt).clientY,
          elem = document.elementFromPoint(x, y);
      touchEvt$1 = evt; // IE does not seem to have native autoscroll,
      // Edge's autoscroll seems too conditional,
      // MACOS Safari does not have autoscroll,
      // Firefox and Chrome are good

      if (fallback || Edge || IE11OrLess || Safari) {
        autoScroll(evt, this.options, elem, fallback); // Listener for pointer element change

        var ogElemScroller = getParentAutoScrollElement(elem, true);

        if (scrolling && (!pointerElemChangedInterval || x !== lastAutoScrollX || y !== lastAutoScrollY)) {
          pointerElemChangedInterval && clearPointerElemChangedInterval(); // Detect for pointer elem change, emulating native DnD behaviour

          pointerElemChangedInterval = setInterval(function () {
            var newElem = getParentAutoScrollElement(document.elementFromPoint(x, y), true);

            if (newElem !== ogElemScroller) {
              ogElemScroller = newElem;
              clearAutoScrolls();
            }

            autoScroll(evt, _this.options, newElem, fallback);
          }, 10);
          lastAutoScrollX = x;
          lastAutoScrollY = y;
        }
      } else {
        // if DnD is enabled (and browser has good autoscrolling), first autoscroll will already scroll, so get parent autoscroll of first autoscroll
        if (!this.options.bubbleScroll || getParentAutoScrollElement(elem, true) === getWindowScrollingElement()) {
          clearAutoScrolls();
          return;
        }

        autoScroll(evt, this.options, getParentAutoScrollElement(elem, false), false);
      }
    }
  };
  return _extends(AutoScroll, {
    pluginName: 'scroll',
    initializeByDefault: true
  });
}

function clearAutoScrolls() {
  autoScrolls.forEach(function (autoScroll) {
    clearInterval(autoScroll.pid);
  });
  autoScrolls = [];
}

function clearPointerElemChangedInterval() {
  clearInterval(pointerElemChangedInterval);
}

var autoScroll = throttle(function (evt, options, rootEl, isFallback) {
  // Bug: https://bugzilla.mozilla.org/show_bug.cgi?id=505521
  if (!options.scroll) return;
  var x = (evt.touches ? evt.touches[0] : evt).clientX,
      y = (evt.touches ? evt.touches[0] : evt).clientY,
      sens = options.scrollSensitivity,
      speed = options.scrollSpeed,
      winScroller = getWindowScrollingElement();
  var scrollThisInstance = false,
      scrollCustomFn; // New scroll root, set scrollEl

  if (scrollRootEl !== rootEl) {
    scrollRootEl = rootEl;
    clearAutoScrolls();
    scrollEl = options.scroll;
    scrollCustomFn = options.scrollFn;

    if (scrollEl === true) {
      scrollEl = getParentAutoScrollElement(rootEl, true);
    }
  }

  var layersOut = 0;
  var currentParent = scrollEl;

  do {
    var el = currentParent,
        rect = getRect(el),
        top = rect.top,
        bottom = rect.bottom,
        left = rect.left,
        right = rect.right,
        width = rect.width,
        height = rect.height,
        canScrollX = void 0,
        canScrollY = void 0,
        scrollWidth = el.scrollWidth,
        scrollHeight = el.scrollHeight,
        elCSS = css(el),
        scrollPosX = el.scrollLeft,
        scrollPosY = el.scrollTop;

    if (el === winScroller) {
      canScrollX = width < scrollWidth && (elCSS.overflowX === 'auto' || elCSS.overflowX === 'scroll' || elCSS.overflowX === 'visible');
      canScrollY = height < scrollHeight && (elCSS.overflowY === 'auto' || elCSS.overflowY === 'scroll' || elCSS.overflowY === 'visible');
    } else {
      canScrollX = width < scrollWidth && (elCSS.overflowX === 'auto' || elCSS.overflowX === 'scroll');
      canScrollY = height < scrollHeight && (elCSS.overflowY === 'auto' || elCSS.overflowY === 'scroll');
    }

    var vx = canScrollX && (Math.abs(right - x) <= sens && scrollPosX + width < scrollWidth) - (Math.abs(left - x) <= sens && !!scrollPosX);
    var vy = canScrollY && (Math.abs(bottom - y) <= sens && scrollPosY + height < scrollHeight) - (Math.abs(top - y) <= sens && !!scrollPosY);

    if (!autoScrolls[layersOut]) {
      for (var i = 0; i <= layersOut; i++) {
        if (!autoScrolls[i]) {
          autoScrolls[i] = {};
        }
      }
    }

    if (autoScrolls[layersOut].vx != vx || autoScrolls[layersOut].vy != vy || autoScrolls[layersOut].el !== el) {
      autoScrolls[layersOut].el = el;
      autoScrolls[layersOut].vx = vx;
      autoScrolls[layersOut].vy = vy;
      clearInterval(autoScrolls[layersOut].pid);

      if (vx != 0 || vy != 0) {
        scrollThisInstance = true;
        /* jshint loopfunc:true */

        autoScrolls[layersOut].pid = setInterval(function () {
          // emulate drag over during autoscroll (fallback), emulating native DnD behaviour
          if (isFallback && this.layer === 0) {
            Sortable.active._onTouchMove(touchEvt$1); // To move ghost if it is positioned absolutely

          }

          var scrollOffsetY = autoScrolls[this.layer].vy ? autoScrolls[this.layer].vy * speed : 0;
          var scrollOffsetX = autoScrolls[this.layer].vx ? autoScrolls[this.layer].vx * speed : 0;

          if (typeof scrollCustomFn === 'function') {
            if (scrollCustomFn.call(Sortable.dragged.parentNode[expando], scrollOffsetX, scrollOffsetY, evt, touchEvt$1, autoScrolls[this.layer].el) !== 'continue') {
              return;
            }
          }

          scrollBy(autoScrolls[this.layer].el, scrollOffsetX, scrollOffsetY);
        }.bind({
          layer: layersOut
        }), 24);
      }
    }

    layersOut++;
  } while (options.bubbleScroll && currentParent !== winScroller && (currentParent = getParentAutoScrollElement(currentParent, false)));

  scrolling = scrollThisInstance; // in case another function catches scrolling as false in between when it is not
}, 30);

var drop = function drop(_ref) {
  var originalEvent = _ref.originalEvent,
      putSortable = _ref.putSortable,
      dragEl = _ref.dragEl,
      activeSortable = _ref.activeSortable,
      dispatchSortableEvent = _ref.dispatchSortableEvent,
      hideGhostForTarget = _ref.hideGhostForTarget,
      unhideGhostForTarget = _ref.unhideGhostForTarget;
  if (!originalEvent) return;
  var toSortable = putSortable || activeSortable;
  hideGhostForTarget();
  var touch = originalEvent.changedTouches && originalEvent.changedTouches.length ? originalEvent.changedTouches[0] : originalEvent;
  var target = document.elementFromPoint(touch.clientX, touch.clientY);
  unhideGhostForTarget();

  if (toSortable && !toSortable.el.contains(target)) {
    dispatchSortableEvent('spill');
    this.onSpill({
      dragEl: dragEl,
      putSortable: putSortable
    });
  }
};

function Revert() {}

Revert.prototype = {
  startIndex: null,
  dragStart: function dragStart(_ref2) {
    var oldDraggableIndex = _ref2.oldDraggableIndex;
    this.startIndex = oldDraggableIndex;
  },
  onSpill: function onSpill(_ref3) {
    var dragEl = _ref3.dragEl,
        putSortable = _ref3.putSortable;
    this.sortable.captureAnimationState();

    if (putSortable) {
      putSortable.captureAnimationState();
    }

    var nextSibling = getChild(this.sortable.el, this.startIndex, this.options);

    if (nextSibling) {
      this.sortable.el.insertBefore(dragEl, nextSibling);
    } else {
      this.sortable.el.appendChild(dragEl);
    }

    this.sortable.animateAll();

    if (putSortable) {
      putSortable.animateAll();
    }
  },
  drop: drop
};

_extends(Revert, {
  pluginName: 'revertOnSpill'
});

function Remove() {}

Remove.prototype = {
  onSpill: function onSpill(_ref4) {
    var dragEl = _ref4.dragEl,
        putSortable = _ref4.putSortable;
    var parentSortable = putSortable || this.sortable;
    parentSortable.captureAnimationState();
    dragEl.parentNode && dragEl.parentNode.removeChild(dragEl);
    parentSortable.animateAll();
  },
  drop: drop
};

_extends(Remove, {
  pluginName: 'removeOnSpill'
});

var lastSwapEl;

function SwapPlugin() {
  function Swap() {
    this.defaults = {
      swapClass: 'sortable-swap-highlight'
    };
  }

  Swap.prototype = {
    dragStart: function dragStart(_ref) {
      var dragEl = _ref.dragEl;
      lastSwapEl = dragEl;
    },
    dragOverValid: function dragOverValid(_ref2) {
      var completed = _ref2.completed,
          target = _ref2.target,
          onMove = _ref2.onMove,
          activeSortable = _ref2.activeSortable,
          changed = _ref2.changed,
          cancel = _ref2.cancel;
      if (!activeSortable.options.swap) return;
      var el = this.sortable.el,
          options = this.options;

      if (target && target !== el) {
        var prevSwapEl = lastSwapEl;

        if (onMove(target) !== false) {
          toggleClass(target, options.swapClass, true);
          lastSwapEl = target;
        } else {
          lastSwapEl = null;
        }

        if (prevSwapEl && prevSwapEl !== lastSwapEl) {
          toggleClass(prevSwapEl, options.swapClass, false);
        }
      }

      changed();
      completed(true);
      cancel();
    },
    drop: function drop(_ref3) {
      var activeSortable = _ref3.activeSortable,
          putSortable = _ref3.putSortable,
          dragEl = _ref3.dragEl;
      var toSortable = putSortable || this.sortable;
      var options = this.options;
      lastSwapEl && toggleClass(lastSwapEl, options.swapClass, false);

      if (lastSwapEl && (options.swap || putSortable && putSortable.options.swap)) {
        if (dragEl !== lastSwapEl) {
          toSortable.captureAnimationState();
          if (toSortable !== activeSortable) activeSortable.captureAnimationState();
          swapNodes(dragEl, lastSwapEl);
          toSortable.animateAll();
          if (toSortable !== activeSortable) activeSortable.animateAll();
        }
      }
    },
    nulling: function nulling() {
      lastSwapEl = null;
    }
  };
  return _extends(Swap, {
    pluginName: 'swap',
    eventProperties: function eventProperties() {
      return {
        swapItem: lastSwapEl
      };
    }
  });
}

function swapNodes(n1, n2) {
  var p1 = n1.parentNode,
      p2 = n2.parentNode,
      i1,
      i2;
  if (!p1 || !p2 || p1.isEqualNode(n2) || p2.isEqualNode(n1)) return;
  i1 = index(n1);
  i2 = index(n2);

  if (p1.isEqualNode(p2) && i1 < i2) {
    i2++;
  }

  p1.insertBefore(n2, p1.children[i1]);
  p2.insertBefore(n1, p2.children[i2]);
}

var multiDragElements = [],
    multiDragClones = [],
    lastMultiDragSelect,
    // for selection with modifier key down (SHIFT)
multiDragSortable,
    initialFolding = false,
    // Initial multi-drag fold when drag started
folding = false,
    // Folding any other time
dragStarted = false,
    dragEl$1,
    clonesFromRect,
    clonesHidden;

function MultiDragPlugin() {
  function MultiDrag(sortable) {
    // Bind all private methods
    for (var fn in this) {
      if (fn.charAt(0) === '_' && typeof this[fn] === 'function') {
        this[fn] = this[fn].bind(this);
      }
    }

    if (sortable.options.supportPointer) {
      on(document, 'pointerup', this._deselectMultiDrag);
    } else {
      on(document, 'mouseup', this._deselectMultiDrag);
      on(document, 'touchend', this._deselectMultiDrag);
    }

    on(document, 'keydown', this._checkKeyDown);
    on(document, 'keyup', this._checkKeyUp);
    this.defaults = {
      selectedClass: 'sortable-selected',
      multiDragKey: null,
      setData: function setData(dataTransfer, dragEl) {
        var data = '';

        if (multiDragElements.length && multiDragSortable === sortable) {
          multiDragElements.forEach(function (multiDragElement, i) {
            data += (!i ? '' : ', ') + multiDragElement.textContent;
          });
        } else {
          data = dragEl.textContent;
        }

        dataTransfer.setData('Text', data);
      }
    };
  }

  MultiDrag.prototype = {
    multiDragKeyDown: false,
    isMultiDrag: false,
    delayStartGlobal: function delayStartGlobal(_ref) {
      var dragged = _ref.dragEl;
      dragEl$1 = dragged;
    },
    delayEnded: function delayEnded() {
      this.isMultiDrag = ~multiDragElements.indexOf(dragEl$1);
    },
    setupClone: function setupClone(_ref2) {
      var sortable = _ref2.sortable,
          cancel = _ref2.cancel;
      if (!this.isMultiDrag) return;

      for (var i = 0; i < multiDragElements.length; i++) {
        multiDragClones.push(clone(multiDragElements[i]));
        multiDragClones[i].sortableIndex = multiDragElements[i].sortableIndex;
        multiDragClones[i].draggable = false;
        multiDragClones[i].style['will-change'] = '';
        toggleClass(multiDragClones[i], this.options.selectedClass, false);
        multiDragElements[i] === dragEl$1 && toggleClass(multiDragClones[i], this.options.chosenClass, false);
      }

      sortable._hideClone();

      cancel();
    },
    clone: function clone(_ref3) {
      var sortable = _ref3.sortable,
          rootEl = _ref3.rootEl,
          dispatchSortableEvent = _ref3.dispatchSortableEvent,
          cancel = _ref3.cancel;
      if (!this.isMultiDrag) return;

      if (!this.options.removeCloneOnHide) {
        if (multiDragElements.length && multiDragSortable === sortable) {
          insertMultiDragClones(true, rootEl);
          dispatchSortableEvent('clone');
          cancel();
        }
      }
    },
    showClone: function showClone(_ref4) {
      var cloneNowShown = _ref4.cloneNowShown,
          rootEl = _ref4.rootEl,
          cancel = _ref4.cancel;
      if (!this.isMultiDrag) return;
      insertMultiDragClones(false, rootEl);
      multiDragClones.forEach(function (clone) {
        css(clone, 'display', '');
      });
      cloneNowShown();
      clonesHidden = false;
      cancel();
    },
    hideClone: function hideClone(_ref5) {
      var _this = this;

      var sortable = _ref5.sortable,
          cloneNowHidden = _ref5.cloneNowHidden,
          cancel = _ref5.cancel;
      if (!this.isMultiDrag) return;
      multiDragClones.forEach(function (clone) {
        css(clone, 'display', 'none');

        if (_this.options.removeCloneOnHide && clone.parentNode) {
          clone.parentNode.removeChild(clone);
        }
      });
      cloneNowHidden();
      clonesHidden = true;
      cancel();
    },
    dragStartGlobal: function dragStartGlobal(_ref6) {
      var sortable = _ref6.sortable;

      if (!this.isMultiDrag && multiDragSortable) {
        multiDragSortable.multiDrag._deselectMultiDrag();
      }

      multiDragElements.forEach(function (multiDragElement) {
        multiDragElement.sortableIndex = index(multiDragElement);
      }); // Sort multi-drag elements

      multiDragElements = multiDragElements.sort(function (a, b) {
        return a.sortableIndex - b.sortableIndex;
      });
      dragStarted = true;
    },
    dragStarted: function dragStarted(_ref7) {
      var _this2 = this;

      var sortable = _ref7.sortable;
      if (!this.isMultiDrag) return;

      if (this.options.sort) {
        // Capture rects,
        // hide multi drag elements (by positioning them absolute),
        // set multi drag elements rects to dragRect,
        // show multi drag elements,
        // animate to rects,
        // unset rects & remove from DOM
        sortable.captureAnimationState();

        if (this.options.animation) {
          multiDragElements.forEach(function (multiDragElement) {
            if (multiDragElement === dragEl$1) return;
            css(multiDragElement, 'position', 'absolute');
          });
          var dragRect = getRect(dragEl$1, false, true, true);
          multiDragElements.forEach(function (multiDragElement) {
            if (multiDragElement === dragEl$1) return;
            setRect(multiDragElement, dragRect);
          });
          folding = true;
          initialFolding = true;
        }
      }

      sortable.animateAll(function () {
        folding = false;
        initialFolding = false;

        if (_this2.options.animation) {
          multiDragElements.forEach(function (multiDragElement) {
            unsetRect(multiDragElement);
          });
        } // Remove all auxiliary multidrag items from el, if sorting enabled


        if (_this2.options.sort) {
          removeMultiDragElements();
        }
      });
    },
    dragOver: function dragOver(_ref8) {
      var target = _ref8.target,
          completed = _ref8.completed,
          cancel = _ref8.cancel;

      if (folding && ~multiDragElements.indexOf(target)) {
        completed(false);
        cancel();
      }
    },
    revert: function revert(_ref9) {
      var fromSortable = _ref9.fromSortable,
          rootEl = _ref9.rootEl,
          sortable = _ref9.sortable,
          dragRect = _ref9.dragRect;

      if (multiDragElements.length > 1) {
        // Setup unfold animation
        multiDragElements.forEach(function (multiDragElement) {
          sortable.addAnimationState({
            target: multiDragElement,
            rect: folding ? getRect(multiDragElement) : dragRect
          });
          unsetRect(multiDragElement);
          multiDragElement.fromRect = dragRect;
          fromSortable.removeAnimationState(multiDragElement);
        });
        folding = false;
        insertMultiDragElements(!this.options.removeCloneOnHide, rootEl);
      }
    },
    dragOverCompleted: function dragOverCompleted(_ref10) {
      var sortable = _ref10.sortable,
          isOwner = _ref10.isOwner,
          insertion = _ref10.insertion,
          activeSortable = _ref10.activeSortable,
          parentEl = _ref10.parentEl,
          putSortable = _ref10.putSortable;
      var options = this.options;

      if (insertion) {
        // Clones must be hidden before folding animation to capture dragRectAbsolute properly
        if (isOwner) {
          activeSortable._hideClone();
        }

        initialFolding = false; // If leaving sort:false root, or already folding - Fold to new location

        if (options.animation && multiDragElements.length > 1 && (folding || !isOwner && !activeSortable.options.sort && !putSortable)) {
          // Fold: Set all multi drag elements's rects to dragEl's rect when multi-drag elements are invisible
          var dragRectAbsolute = getRect(dragEl$1, false, true, true);
          multiDragElements.forEach(function (multiDragElement) {
            if (multiDragElement === dragEl$1) return;
            setRect(multiDragElement, dragRectAbsolute); // Move element(s) to end of parentEl so that it does not interfere with multi-drag clones insertion if they are inserted
            // while folding, and so that we can capture them again because old sortable will no longer be fromSortable

            parentEl.appendChild(multiDragElement);
          });
          folding = true;
        } // Clones must be shown (and check to remove multi drags) after folding when interfering multiDragElements are moved out


        if (!isOwner) {
          // Only remove if not folding (folding will remove them anyways)
          if (!folding) {
            removeMultiDragElements();
          }

          if (multiDragElements.length > 1) {
            var clonesHiddenBefore = clonesHidden;

            activeSortable._showClone(sortable); // Unfold animation for clones if showing from hidden


            if (activeSortable.options.animation && !clonesHidden && clonesHiddenBefore) {
              multiDragClones.forEach(function (clone) {
                activeSortable.addAnimationState({
                  target: clone,
                  rect: clonesFromRect
                });
                clone.fromRect = clonesFromRect;
                clone.thisAnimationDuration = null;
              });
            }
          } else {
            activeSortable._showClone(sortable);
          }
        }
      }
    },
    dragOverAnimationCapture: function dragOverAnimationCapture(_ref11) {
      var dragRect = _ref11.dragRect,
          isOwner = _ref11.isOwner,
          activeSortable = _ref11.activeSortable;
      multiDragElements.forEach(function (multiDragElement) {
        multiDragElement.thisAnimationDuration = null;
      });

      if (activeSortable.options.animation && !isOwner && activeSortable.multiDrag.isMultiDrag) {
        clonesFromRect = _extends({}, dragRect);
        var dragMatrix = matrix(dragEl$1, true);
        clonesFromRect.top -= dragMatrix.f;
        clonesFromRect.left -= dragMatrix.e;
      }
    },
    dragOverAnimationComplete: function dragOverAnimationComplete() {
      if (folding) {
        folding = false;
        removeMultiDragElements();
      }
    },
    drop: function drop(_ref12) {
      var evt = _ref12.originalEvent,
          rootEl = _ref12.rootEl,
          parentEl = _ref12.parentEl,
          sortable = _ref12.sortable,
          dispatchSortableEvent = _ref12.dispatchSortableEvent,
          oldIndex = _ref12.oldIndex,
          putSortable = _ref12.putSortable;
      var toSortable = putSortable || this.sortable;
      if (!evt) return;
      var options = this.options,
          children = parentEl.children; // Multi-drag selection

      if (!dragStarted) {
        if (options.multiDragKey && !this.multiDragKeyDown) {
          this._deselectMultiDrag();
        }

        toggleClass(dragEl$1, options.selectedClass, !~multiDragElements.indexOf(dragEl$1));

        if (!~multiDragElements.indexOf(dragEl$1)) {
          multiDragElements.push(dragEl$1);
          dispatchEvent({
            sortable: sortable,
            rootEl: rootEl,
            name: 'select',
            targetEl: dragEl$1,
            originalEvt: evt
          }); // Modifier activated, select from last to dragEl

          if (evt.shiftKey && lastMultiDragSelect && sortable.el.contains(lastMultiDragSelect)) {
            var lastIndex = index(lastMultiDragSelect),
                currentIndex = index(dragEl$1);

            if (~lastIndex && ~currentIndex && lastIndex !== currentIndex) {
              // Must include lastMultiDragSelect (select it), in case modified selection from no selection
              // (but previous selection existed)
              var n, i;

              if (currentIndex > lastIndex) {
                i = lastIndex;
                n = currentIndex;
              } else {
                i = currentIndex;
                n = lastIndex + 1;
              }

              for (; i < n; i++) {
                if (~multiDragElements.indexOf(children[i])) continue;
                toggleClass(children[i], options.selectedClass, true);
                multiDragElements.push(children[i]);
                dispatchEvent({
                  sortable: sortable,
                  rootEl: rootEl,
                  name: 'select',
                  targetEl: children[i],
                  originalEvt: evt
                });
              }
            }
          } else {
            lastMultiDragSelect = dragEl$1;
          }

          multiDragSortable = toSortable;
        } else {
          multiDragElements.splice(multiDragElements.indexOf(dragEl$1), 1);
          lastMultiDragSelect = null;
          dispatchEvent({
            sortable: sortable,
            rootEl: rootEl,
            name: 'deselect',
            targetEl: dragEl$1,
            originalEvt: evt
          });
        }
      } // Multi-drag drop


      if (dragStarted && this.isMultiDrag) {
        // Do not "unfold" after around dragEl if reverted
        if ((parentEl[expando].options.sort || parentEl !== rootEl) && multiDragElements.length > 1) {
          var dragRect = getRect(dragEl$1),
              multiDragIndex = index(dragEl$1, ':not(.' + this.options.selectedClass + ')');
          if (!initialFolding && options.animation) dragEl$1.thisAnimationDuration = null;
          toSortable.captureAnimationState();

          if (!initialFolding) {
            if (options.animation) {
              dragEl$1.fromRect = dragRect;
              multiDragElements.forEach(function (multiDragElement) {
                multiDragElement.thisAnimationDuration = null;

                if (multiDragElement !== dragEl$1) {
                  var rect = folding ? getRect(multiDragElement) : dragRect;
                  multiDragElement.fromRect = rect; // Prepare unfold animation

                  toSortable.addAnimationState({
                    target: multiDragElement,
                    rect: rect
                  });
                }
              });
            } // Multi drag elements are not necessarily removed from the DOM on drop, so to reinsert
            // properly they must all be removed


            removeMultiDragElements();
            multiDragElements.forEach(function (multiDragElement) {
              if (children[multiDragIndex]) {
                parentEl.insertBefore(multiDragElement, children[multiDragIndex]);
              } else {
                parentEl.appendChild(multiDragElement);
              }

              multiDragIndex++;
            }); // If initial folding is done, the elements may have changed position because they are now
            // unfolding around dragEl, even though dragEl may not have his index changed, so update event
            // must be fired here as Sortable will not.

            if (oldIndex === index(dragEl$1)) {
              var update = false;
              multiDragElements.forEach(function (multiDragElement) {
                if (multiDragElement.sortableIndex !== index(multiDragElement)) {
                  update = true;
                  return;
                }
              });

              if (update) {
                dispatchSortableEvent('update');
              }
            }
          } // Must be done after capturing individual rects (scroll bar)


          multiDragElements.forEach(function (multiDragElement) {
            unsetRect(multiDragElement);
          });
          toSortable.animateAll();
        }

        multiDragSortable = toSortable;
      } // Remove clones if necessary


      if (rootEl === parentEl || putSortable && putSortable.lastPutMode !== 'clone') {
        multiDragClones.forEach(function (clone) {
          clone.parentNode && clone.parentNode.removeChild(clone);
        });
      }
    },
    nullingGlobal: function nullingGlobal() {
      this.isMultiDrag = dragStarted = false;
      multiDragClones.length = 0;
    },
    destroyGlobal: function destroyGlobal() {
      this._deselectMultiDrag();

      off(document, 'pointerup', this._deselectMultiDrag);
      off(document, 'mouseup', this._deselectMultiDrag);
      off(document, 'touchend', this._deselectMultiDrag);
      off(document, 'keydown', this._checkKeyDown);
      off(document, 'keyup', this._checkKeyUp);
    },
    _deselectMultiDrag: function _deselectMultiDrag(evt) {
      if (typeof dragStarted !== "undefined" && dragStarted) return; // Only deselect if selection is in this sortable

      if (multiDragSortable !== this.sortable) return; // Only deselect if target is not item in this sortable

      if (evt && closest(evt.target, this.options.draggable, this.sortable.el, false)) return; // Only deselect if left click

      if (evt && evt.button !== 0) return;

      while (multiDragElements.length) {
        var el = multiDragElements[0];
        toggleClass(el, this.options.selectedClass, false);
        multiDragElements.shift();
        dispatchEvent({
          sortable: this.sortable,
          rootEl: this.sortable.el,
          name: 'deselect',
          targetEl: el,
          originalEvt: evt
        });
      }
    },
    _checkKeyDown: function _checkKeyDown(evt) {
      if (evt.key === this.options.multiDragKey) {
        this.multiDragKeyDown = true;
      }
    },
    _checkKeyUp: function _checkKeyUp(evt) {
      if (evt.key === this.options.multiDragKey) {
        this.multiDragKeyDown = false;
      }
    }
  };
  return _extends(MultiDrag, {
    // Static methods & properties
    pluginName: 'multiDrag',
    utils: {
      /**
       * Selects the provided multi-drag item
       * @param  {HTMLElement} el    The element to be selected
       */
      select: function select(el) {
        var sortable = el.parentNode[expando];
        if (!sortable || !sortable.options.multiDrag || ~multiDragElements.indexOf(el)) return;

        if (multiDragSortable && multiDragSortable !== sortable) {
          multiDragSortable.multiDrag._deselectMultiDrag();

          multiDragSortable = sortable;
        }

        toggleClass(el, sortable.options.selectedClass, true);
        multiDragElements.push(el);
      },

      /**
       * Deselects the provided multi-drag item
       * @param  {HTMLElement} el    The element to be deselected
       */
      deselect: function deselect(el) {
        var sortable = el.parentNode[expando],
            index = multiDragElements.indexOf(el);
        if (!sortable || !sortable.options.multiDrag || !~index) return;
        toggleClass(el, sortable.options.selectedClass, false);
        multiDragElements.splice(index, 1);
      }
    },
    eventProperties: function eventProperties() {
      var _this3 = this;

      var oldIndicies = [],
          newIndicies = [];
      multiDragElements.forEach(function (multiDragElement) {
        oldIndicies.push({
          multiDragElement: multiDragElement,
          index: multiDragElement.sortableIndex
        }); // multiDragElements will already be sorted if folding

        var newIndex;

        if (folding && multiDragElement !== dragEl$1) {
          newIndex = -1;
        } else if (folding) {
          newIndex = index(multiDragElement, ':not(.' + _this3.options.selectedClass + ')');
        } else {
          newIndex = index(multiDragElement);
        }

        newIndicies.push({
          multiDragElement: multiDragElement,
          index: newIndex
        });
      });
      return {
        items: _toConsumableArray(multiDragElements),
        clones: [].concat(multiDragClones),
        oldIndicies: oldIndicies,
        newIndicies: newIndicies
      };
    },
    optionListeners: {
      multiDragKey: function multiDragKey(key) {
        key = key.toLowerCase();

        if (key === 'ctrl') {
          key = 'Control';
        } else if (key.length > 1) {
          key = key.charAt(0).toUpperCase() + key.substr(1);
        }

        return key;
      }
    }
  });
}

function insertMultiDragElements(clonesInserted, rootEl) {
  multiDragElements.forEach(function (multiDragElement, i) {
    var target = rootEl.children[multiDragElement.sortableIndex + (clonesInserted ? Number(i) : 0)];

    if (target) {
      rootEl.insertBefore(multiDragElement, target);
    } else {
      rootEl.appendChild(multiDragElement);
    }
  });
}
/**
 * Insert multi-drag clones
 * @param  {[Boolean]} elementsInserted  Whether the multi-drag elements are inserted
 * @param  {HTMLElement} rootEl
 */


function insertMultiDragClones(elementsInserted, rootEl) {
  multiDragClones.forEach(function (clone, i) {
    var target = rootEl.children[clone.sortableIndex + (elementsInserted ? Number(i) : 0)];

    if (target) {
      rootEl.insertBefore(clone, target);
    } else {
      rootEl.appendChild(clone);
    }
  });
}

function removeMultiDragElements() {
  multiDragElements.forEach(function (multiDragElement) {
    if (multiDragElement === dragEl$1) return;
    multiDragElement.parentNode && multiDragElement.parentNode.removeChild(multiDragElement);
  });
}

Sortable.mount(new AutoScrollPlugin());
Sortable.mount(Remove, Revert);

/* harmony default export */ __webpack_exports__["default"] = (Sortable);



/***/ }),

/***/ "./resources/js/MediaLibraryAbstract.js":
/*!**********************************************!*\
  !*** ./resources/js/MediaLibraryAbstract.js ***!
  \**********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return MediaLibraryAbstract; });
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var defaults = {
  allow_multiple_selection: false,
  multilang: $('html').attr('lang') ? true : false,
  currentLang: $('html').attr('lang'),
  autoremove: false,
  callBy: 'ajax',
  callUrl: Route('modale.getModale', {
    name: 'modaleMediaLibrary'
  }),
  contextListener: window,
  modalId: '#modalMediaLibrary'
};

var MediaLibraryAbstract = /*#__PURE__*/function () {
  function MediaLibraryAbstract() {
    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

    _classCallCheck(this, MediaLibraryAbstract);

    this.options = _objectSpread(_objectSpread({}, defaults), options);
    this.ModalBinded = false;
    this.hooks = {
      init: function init(instance) {},
      addSelection: function addSelection(instance) {},
      removeSelection: function removeSelection(instance) {},
      select: function select(instance) {}
    };
    this.generateModalSetup();
    this.start();
  }

  _createClass(MediaLibraryAbstract, [{
    key: "generateModalSetup",
    value: function generateModalSetup() {
      var options = this.getOptions();
      var localSetup = {
        form: "".concat(options.modalId, " form"),
        formInputs: "".concat(options.modalId, " form .form-control"),
        dropzone: "".concat(options.modalId, " div.dropzone"),
        triggerDropzone: "".concat(options.modalId, " .js-trigger-dropzone"),
        btnCall: '.btn-primary',
        selection: '.js-selection',
        clearSelection: '.js-clear-selection',
        selWrapper: '.selection_wrapper',
        mediaSelectionInput: 'input[type="hidden"]',
        acceptModal: "".concat(options.modalId, " .js-accept"),
        declineModal: "".concat(options.modalId, " .js-clear"),
        selectImage: "".concat(options.modalId, " .js-select-image"),
        closeModal: "".concat(options.modalId, " .close")
      };
      this.options.setup = _objectSpread(_objectSpread({}, localSetup), options.setup);
      return this;
    }
  }, {
    key: "getOptions",
    value: function getOptions() {
      return this.options;
    }
  }, {
    key: "getModalId",
    value: function getModalId() {
      return this.options.ModalId;
    }
  }, {
    key: "setModalActivate",
    value: function setModalActivate() {
      var _boolean = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

      this.ModalBinded = _boolean;
      return this;
    }
  }, {
    key: "makeDropzone",
    value: function makeDropzone() {
      var options = this.getOptions();
      var dropzoneOpts = {
        url: Route('medias.store'),
        dictDefaultMessage: '',
        paramName: 'src',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        acceptedFiles: 'image/*,video/*,audio/*',
        createImageThumbnails: false,
        sending: function sending(file, xhr, formData) {
          /* Maybe display some more file information on your page */
          formData.append('title', file.name);
        },
        success: function success(data, server) {
          console.log(server);

          if ($(options.setup.dropzone).hasClass('default-start')) {
            $.ajax({
              method: 'GET',
              url: Route('modale.content', {
                name: 'modaleMediaLibrary'
              }),
              success: function success(data) {
                console.log(data);
                $(options.modalId).find('.modal-body').html('').append(data.html);
              },
              error: function error(err) {
                console.log('whoops', err);
              }
            });
          }
        }
      };
      this.dropzone = $(options.setup.dropzone).dropzone(dropzoneOpts);
    }
  }, {
    key: "setModalListeners",
    value: function setModalListeners() {
      var options = this.getOptions();
      var self = this;
      $('body').on('click', options.setup.acceptModal, function (e) {
        e.preventDefault();

        if ($(this).hasClass('disabled')) {
          return false;
        }

        if (!$(options.modalId).hasClass('from-quill')) {
          var $data = $(this).attr('data-selection');
          $(options.setup.mediaSelectionInput).val($data);
          self.generateSelection([$data]);
          $(options.contextListener).find(options.setup.btnCall).css({
            'display': 'none'
          });
        } else {
          $(options.modalId).trigger('makequillcontent', $(options.modalId).find('.js-select-image.selected'));
        }

        $(options.modalId).modal('hide');
      });
      $('body').on('click', options.setup.declineModal, function (e) {
        e.preventDefault();

        if (!$(options.modalId).hasClass('from-quill')) {
          var selectioned = $(options.modalId).find('.js-select-image.selected');
          var acceptBtn = $(options.modalId).find('.js-accept');
          selectioned.removeClass('selected');
          $(options.setup.acceptModal).attr({
            'disabled': 'disabled'
          });
          $(options.setup.acceptModal).removeAttr('data-selection');
          $(options.setup.acceptModal).addClass('disabled');
          $(options.setup.form).removeAttr('action');
        }
      });
      $('body').on('click', options.setup.selectImage, function (e) {
        e.preventDefault();
        var $data = $(this).attr('data-id');
        var sel = $(options.modalId).find('.js-select-image');
        var acceptBtn = $(options.modalId).find('.js-accept');
        var clearBtn = $(options.modalId).find('.js-clear');
        var informations = JSON.parse($(this).attr('data-informations'));

        if (options.allow_multiple_selection == false) {
          sel.not($(this)).removeClass('selected');
          $(this).toggleClass('selected');
          var hasSelection = $(options.modalId).find('.js-select-image.selected');

          if (hasSelection.length > 0) {
            acceptBtn.removeAttr('disabled').removeClass('disabled');
            acceptBtn.attr({
              'data-selection': $data
            });
            $(options.setup.form).attr({
              'action': $(this).attr('data-action')
            });
            self.showAndClearFieldsUpdate(informations, false);
          } else {
            acceptBtn.attr({
              'disabled': 'disabled'
            });
            acceptBtn.removeAttr('data-selection');
            acceptBtn.addClass('disabled');
            $(options.setup.form).removeAttr('action');
            self.showAndClearFieldsUpdate(informations, true);
          }
        } else {//@todo
        }
      });
      $('body').on('click', options.setup.closeModal, function (e) {
        var sel = $(options.modalId).find('.js-select-image.selected');
        sel.trigger('click');
      });
      $('body').on('blur', options.setup.formInputs, function (e) {
        if ($(options.setup.form).get(0).hasAttribute('action') === false) {
          return false;
        }

        var datas = $(options.setup.form).serializeFormJSON();
        self.performRequest({
          method: 'POST',
          url: $(options.setup.form).attr('action'),
          data: datas,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        }, function (err, data) {
          if (err != null) {
            throw new Error(err);
          }

          $('.js-select-image[data-id="' + data.media.id + '"]').attr({
            'data-informations': JSON.stringify(data.media)
          });
        });
      });

      if (options.autoremove != null && options.autoremove) {
        $(document).on('hidden.bs.modal', options.modalId, function (e) {
          // self.dropzone.disable();
          var dropjs = Dropzone.forElement(self.dropzone.get(0));
          $(dropjs.hiddenFileInput).remove();
          $(this).remove();
        });
      }

      $('body').on('click', options.setup.triggerDropzone, function (e) {
        e.preventDefault();
        $(options.setup.dropzone).trigger('click');
      });
    }
  }, {
    key: "generateSelection",
    value: function generateSelection(arraySelection) {
      var options = this.getOptions();
      var sel_wrapper = $(options.contextListener).find(options.setup.selWrapper);

      if (options.allow_multiple_selection == false && sel_wrapper.children().length > 0) {
        sel_wrapper.html('');
      }

      $.each(arraySelection, function (i, selectionId) {
        var the_el = $(options.modalId).find('.js-select-image[data-id="' + selectionId + '"]');
        var clonedEl = the_el.parent().clone(true);
        clonedEl.find('.js-select-image').removeClass('js-select-image').removeClass('selected').addClass('js-selection').removeAttr('data-action').append('<a href="#" data-id="' + selectionId + '" class="close js-clear-selection">x</a>');
        sel_wrapper.append(clonedEl);
      });
    }
  }, {
    key: "showAndClearFieldsUpdate",
    value: function showAndClearFieldsUpdate(object, clear) {
      var objectKeys = Object.keys(object);
      var options = this.getOptions();
      var el = $(options.setup.form);
      objectKeys.forEach(function (key) {
        var jqueryCheck = el.find('[name="' + key + '"]');

        if (jqueryCheck) {
          if (jqueryCheck.val() && clear) {
            jqueryCheck.val('');
          } else {
            jqueryCheck.val(object[key]);
          }
        }
      });
    }
  }, {
    key: "performRequest",
    value: function performRequest() {
      var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var callback = arguments.length > 1 ? arguments[1] : undefined;
      $.ajax(options).done(function (data) {
        callback(null, data);
      }).fail(function (err) {
        callback(err, null);
      });
      return this;
    }
  }, {
    key: "setListeners",
    value: function setListeners() {
      var self = this;
      var options = this.getOptions();
      $(options.contextListener).on('click', options.setup.btnCall, function (e) {
        e.preventDefault();

        if (options.callBy == "ajax") {
          self.performRequest({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'GET',
            url: options.callUrl
          }, function (err, data) {
            if (err != null) {
              throw new Error(err);
            }

            $('body').append(data.html);
            setTimeout(function () {
              $(options.setup.form).removeAttr('action');
              self.makeDropzone();
              $(options.modalId).modal('show');
            }, 200);
          });
        } else {
          $(options.setup.form).removeAttr('action');
          self.makeDropzone();
          $(options.modalId).modal('show');
        }
      });
      $(options.contextListener).on('click', options.setup.selection, function (e) {
        e.preventDefault();

        if (options.callBy == "ajax") {
          var $btnCall = $(options.contextListener).find(options.setup.btnCall);
          $btnCall.trigger('click');
          setTimeout(function () {
            $(options.modalId).find('.js-select-image[data-id="' + $btnCall.attr('data-id') + '"]').trigger('click');
          }, 300);
        } else {
          $(options.modalId).modal('show');
        }
      });
      $(options.contextListener).on('click', options.setup.clearSelection, function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $data = $(this).attr('data-id');

        if (options.allow_multiple_selection == false) {
          $(options.contextListener).find(options.setup.mediaSelectionInput).val('');
          $(this).parent().parent().remove();
          var the_el = $(options.modalId).find('.js-select-image[data-id="' + $data + '"]');
          the_el.trigger('click');
          $(options.contextListener).find(options.setup.btnCall).css({
            'display': ''
          });
        } else {}
      });
      this.setModalListeners();
      var v = $(options.contextListener).find(options.setup.mediaSelectionInput);

      if (v.val() > 0) {
        var selected = $(options.modalId).find('.js-select-image[data-id="' + v.val() + '"]');
        selected.trigger('click');
        $(options.modalId).find('.js-accept').trigger('click');
      }
    }
  }, {
    key: "start",
    value: function start() {
      console.log(this);
      this.hooks.init(this);
      this.setListeners();
    }
  }]);

  return MediaLibraryAbstract;
}();



/***/ }),

/***/ "./resources/js/extensions-call.js":
/*!*****************************************!*\
  !*** ./resources/js/extensions-call.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// const { default: Route } = require("./RouteAbstract");
//call extensions
window.Select2InitFunction = __webpack_require__(/*! ./extensions/select2Field */ "./resources/js/extensions/select2Field.js")["default"];
window.QuillEditorInitFunction = __webpack_require__(/*! ./extensions/quillEditorField */ "./resources/js/extensions/quillEditorField.js")["default"];
window.UploadEditInitFunction = __webpack_require__(/*! ./extensions/editUploadField */ "./resources/js/extensions/editUploadField.js")["default"];
window.MediaLibraryInitFunction = __webpack_require__(/*! ./extensions/mediaLibraryField */ "./resources/js/extensions/mediaLibraryField.js")["default"];
window.LarabergInitFunction = __webpack_require__(/*! ./extensions/larabergField */ "./resources/js/extensions/larabergField.js")["default"];
window.PasswordGeneratorInitFunction = __webpack_require__(/*! ./extensions/generatorPasswordField */ "./resources/js/extensions/generatorPasswordField.js")["default"];
window.media_library = __webpack_require__(/*! ./MediaLibraryAbstract */ "./resources/js/MediaLibraryAbstract.js")["default"];
window.lfmInitFunction = __webpack_require__(/*! ./extensions/lfmField */ "./resources/js/extensions/lfmField.js")["default"];
jQuery(document).ready(function ($) {
  if (window.admin.select2Fields.length > 0) {
    Select2InitFunction(window.admin.select2Fields);
  }

  if (window.admin.quillEditorFields.length > 0) {
    QuillEditorInitFunction(window.admin.quillEditorFields);
  }

  if (window.admin.editUploadFields.length > 0) {
    UploadEditInitFunction(window.admin.editUploadFields);
  }

  if (window.admin.mediaLibraryFields.length > 0) {
    MediaLibraryInitFunction(window.admin.mediaLibraryFields);
  }

  if (window.admin.larabergFields.length > 0) {
    LarabergInitFunction(window.admin.larabergFields);
  }

  if (window.admin.generatorPasswordFields.length > 0) {
    PasswordGeneratorInitFunction(window.admin.generatorPasswordFields);
  }

  if (window.admin.lfmFields.length > 0) {
    lfmInitFunction(window.admin.lfmFields);
  }
});

/***/ }),

/***/ "./resources/js/extensions/editUploadField.js":
/*!****************************************************!*\
  !*** ./resources/js/extensions/editUploadField.js ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return EditUploadInititalization; });
function EditUploadInititalization(fields) {
  $.each(fields, function (i, el) {
    var preview_container_jq = $(el.selector);
    var data_preview = preview_container_jq.attr('data-preview');
    var preview = preview_container_jq.find('.preview');
    var preview_input = preview_container_jq.find('[type="file"]');
    var preview_clear = preview_container_jq.find('.close');

    if (data_preview.length > 0) {
      setPreview(data_preview);
    }

    preview_input.on('change', function (e) {
      readTheFile(e);
    });
    preview_clear.on('click', function (e) {
      e.preventDefault();
      setPreview('');
    });

    function setPreview(previewUrl) {
      if (previewUrl == '') {
        preview.parent().removeClass('has-preview');
      } else {
        preview.parent().addClass('has-preview');
      }

      preview.css('background-image', "url(" + previewUrl + ")");
    }

    function readTheFile(evt) {
      var files = evt.target.files; // FileList object
      // use the 1st file from the list

      f = files[0];
      var reader = new FileReader(); // Closure to capture the file information.

      reader.onload = function (e) {
        setPreview(e.target.result);
      }; // Read in the image file as a data URL.


      reader.readAsDataURL(f);
    }
  });
}

/***/ }),

/***/ "./resources/js/extensions/generatorPasswordField.js":
/*!***********************************************************!*\
  !*** ./resources/js/extensions/generatorPasswordField.js ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return GeneratorPasswordInititalization; });
function GeneratorPasswordInititalization(fields) {
  $.each(fields, function (i, el) {
    var elScope = $('#' + el.selector);
    var Input = elScope.find('input[type="text"]');
    var BtnGenerator = elScope.find('button');
    BtnGenerator.on('click', function (e) {
      e.preventDefault();
      Input.val(PasswordGenerator());
    });
  });

  function PasswordGenerator() {
    return Math.random().toString(36).slice(2);
  }
}

/***/ }),

/***/ "./resources/js/extensions/larabergField.js":
/*!**************************************************!*\
  !*** ./resources/js/extensions/larabergField.js ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return LarabergInititalization; });
function LarabergInititalization(fields) {
  $.each(fields, function (i, el) {
    var textarea = $('#' + el.selector + ' textarea');
    var laraberg = Laraberg.init(textarea.attr('id'), {
      laravelFilemanager: true
    });
  });
}

/***/ }),

/***/ "./resources/js/extensions/lfmField.js":
/*!*********************************************!*\
  !*** ./resources/js/extensions/lfmField.js ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return LFMField; });
/* harmony import */ var sortablejs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! sortablejs */ "./node_modules/sortablejs/modular/sortable.esm.js");


var getMime = __webpack_require__(/*! name2mime */ "./node_modules/name2mime/lib/index.js");

function LFMField(fields) {
  var selectedItems = [];

  function GenerateSelection(el, arraySelection) {
    var sel_wrapper = el.find('.row-selection');
    sel_wrapper.html('');
    var count = arraySelection.length;
    var class_to_apply = 'col-12 js-selection';

    if (count > 1) {
      class_to_apply = 'js-selection col-12 ' + ' col-lg-' + 12 / count;
    }

    $.each(arraySelection, function (i, selection) {
      var tpl = "\n                <div class=\"".concat(class_to_apply, "\">\n                    <img class=\"img-fluid\" src=\"").concat(selection.url, "\" alt=\"").concat(selection.name, "\" />\n                </div>\n            ");
      sel_wrapper.append(tpl);
    });
  }

  function formatSourcesEntries(arraySelection) {
    var $sel = [];
    $.each(arraySelection, function (i, selection) {
      $sel.push({
        'name': selection.name,
        'file': {
          'type': getMime(selection.name)
        }
      });
    });
    return $sel;
  }

  function getSelection(ifr) {
    var items = ifr[0].contentWindow.getSelectedItems();
    var itemsHtml = ifr.contents().find('#content > a');
    items.forEach(function (item) {
      // if(item.name == )
      $.each(itemsHtml, function (i, it) {
        if (item.name == $(it).find(".info .item_name").text()) {
          item.id = parseInt($(it).attr('data-id'));
        }
      });
    });
    return items;
  }

  function updateStyle(ifr) {
    selectedItems.forEach(function (item, index) {
      var $it = $(ifr).contents().find('[data-id=' + item.id + ']');
      var $square = $it.find('.square');
      $square.hasClass('selected') ? $($square).removeClass('selected') : $($square).addClass('selected');
      $square.trigger('click');
    });
    ifr[0].contentWindow.toggleActions();
  }

  function findIndexFromName(ifr, json) {
    var $id = null;
    $.each(ifr[0].contentWindow.items, function (i, item) {
      if (item.name == json[0].name) {
        $id = i;
        return false;
      }
    });
    return $id;
  }

  $.each(fields, function (i, el) {
    var $el_wrapper = $('#' + el.selector);
    var $el = $('#' + el.selector + ' [type="button"]');
    var modale = $('#modalFileManager');
    var ifr = modale.find('iframe');
    var $hidden = $el_wrapper.find('[type="hidden"]');
    var confirm = ifr.contents().find('#actions a[data-action="use"]');

    if ($hidden.val().length > 0) {
      var fieldList = [{
        name: $hidden.val(),
        'file': {
          'type': getMime($hidden.val())
        },
        url: $hidden.attr('data-path')
      }];
      var json = formatSourcesEntries(fieldList);
      $hidden.val(JSON.stringify(json));
      selectedItems = fieldList;
      GenerateSelection($el_wrapper, selectedItems);
    }

    $el.on('click', function (e) {
      e.preventDefault();
      modale.modal('show');

      if (selectedItems.length > 0) {
        updateStyle(ifr);
      } // window.filemanager();


      confirm = ifr.contents().find('#actions a[data-action="use"]');
      confirm.on('click', function (e) {
        selectedItems = getSelection(ifr);
        GenerateSelection($el_wrapper, selectedItems);
        var json = formatSourcesEntries(selectedItems);
        $hidden.val(JSON.stringify(json));
        modale.modal('hide');
      });
    });
    modale.on('show.bs.modal', function (e) {
      if ($hidden.val().length > 0) {
        selectedItems[0].id = findIndexFromName(ifr, JSON.parse($hidden.val()));
        updateStyle(ifr);
      }
    });
  });
}

/***/ }),

/***/ "./resources/js/extensions/mediaLibraryField.js":
/*!******************************************************!*\
  !*** ./resources/js/extensions/mediaLibraryField.js ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return MediaLibraryInititalization; });
function MediaLibraryInititalization(fields) {
  function GenerateSelection(el, modal, arraySelection) {
    var sel_wrapper = el.find('.selection_wrapper');

    if (el.allow_multiple_selection == false && sel_wrapper.children().length > 0) {
      sel_wrapper.html('');
    }

    $.each(arraySelection, function (i, selectionId) {
      var the_el = modal.find('.js-select-image[data-id="' + selectionId + '"]');
      var clonedEl = the_el.parent().clone(true);
      clonedEl.find('.js-select-image').removeClass('js-select-image').removeClass('selected').addClass('js-selection').removeAttr('data-action').append('<a href="#" data-id="' + selectionId + '" class="close js-clear-selection">x</a>');
      sel_wrapper.append(clonedEl);
    });
  }

  function showAndClearFieldsUpdate(object, clear, el) {
    var objectKeys = Object.keys(object);
    objectKeys.forEach(function (key) {
      var jqueryCheck = el.find('[name="' + key + '"]');

      if (jqueryCheck) {
        if (jqueryCheck.val() && clear) {
          jqueryCheck.val('');
        } else {
          jqueryCheck.val(object[key]);
        }
      }
    });
  }

  $.each(fields, function (i, el) {
    var dropzoneOpts = {
      url: Route('medias.store'),
      dictDefaultMessage: '',
      paramName: 'src',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      acceptedFiles: 'image/*,video/*,audio/*',
      createImageThumbnails: false,
      sending: function sending(file, xhr, formData) {
        /* Maybe display some more file information on your page */
        formData.append('title', file.name);
      },
      success: function success(data, server) {
        console.log(server);

        if (DropzoneElm.hasClass('default-start')) {
          $.ajax({
            method: 'GET',
            url: Route('modale.content', {
              name: 'modaleMediaLibrary'
            }),
            success: function success(data) {
              console.log(data);
              ModalMediaLibrary.find('.modal-body').html('').append(data.html);
              formUpdateMediaLibrary = ModalMediaLibrary.find('form');
              DropzoneElm = ModalMediaLibrary.find('div.dropzone');
              DropzoneJs = DropzoneElm.dropzone(dropzoneOpts);
            },
            error: function error(err) {
              console.log('whoops', err);
            }
          });
        }
      }
    };
    var mediaLibrary_container = $(el.selector);
    var btnCallModal = mediaLibrary_container.find('.form-group > .btn-primary');
    var cibledInput = mediaLibrary_container.find(' input[type="hidden"]');
    var ModalMediaLibrary = $('#modalMediaLibrary');
    var formUpdateMediaLibrary = ModalMediaLibrary.find('form');
    var DropzoneElm = ModalMediaLibrary.find('div.dropzone');
    var TriggerDropZone = ModalMediaLibrary.find('.js-trigger-dropzone');
    var DropzoneJs = DropzoneElm.dropzone(dropzoneOpts);
    mediaLibrary_container.on('click', '.js-selection', function (e) {
      e.preventDefault();
      ModalMediaLibrary.modal('show');
    });
    mediaLibrary_container.on('click', '.js-clear-selection', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var $data = $(this).attr('data-id');

      if (el.allow_multiple_selection == false) {
        cibledInput.val('');
        $(this).parent().parent().remove();
        var the_el = ModalMediaLibrary.find('.js-select-image[data-id="' + $data + '"]');
        the_el.trigger('click');
        btnCallModal.css({
          'display': ''
        });
      } else {}
    });
    ModalMediaLibrary.on('click', '.js-accept', function (e) {
      e.preventDefault();

      if ($(this).hasClass('disabled')) {
        return false;
      }

      if (!ModalMediaLibrary.hasClass('from-quill')) {
        var $data = $(this).attr('data-selection');
        cibledInput.val($data);
        GenerateSelection(mediaLibrary_container, ModalMediaLibrary, [$data]);
        btnCallModal.css({
          'display': 'none'
        });
      } else {
        ModalMediaLibrary.trigger('makequillcontent', ModalMediaLibrary.find('.js-select-image.selected'));
      }

      ModalMediaLibrary.modal('hide');
    });
    ModalMediaLibrary.on('click', '.js-clear', function (e) {
      e.preventDefault();

      if (!ModalMediaLibrary.hasClass('from-quill')) {
        console.log(ModalMediaLibrary);
        var selectioned = ModalMediaLibrary.find('.js-select-image.selected');
        var acceptBtn = ModalMediaLibrary.find('.js-accept');
        selectioned.removeClass('selected');
        acceptBtn.attr({
          'disabled': 'disabled'
        });
        acceptBtn.removeAttr('data-selection');
        acceptBtn.addClass('disabled');
        formUpdateMediaLibrary.removeAttr('action');
      }
    });
    ModalMediaLibrary.on('click', '.js-select-image', function (e) {
      e.preventDefault();
      var $data = $(this).attr('data-id');
      var sel = ModalMediaLibrary.find('.js-select-image');
      var acceptBtn = ModalMediaLibrary.find('.js-accept');
      var clearBtn = ModalMediaLibrary.find('.js-clear');
      var informations = JSON.parse($(this).attr('data-informations'));

      if (el.allow_multiple_selection == false) {
        sel.not($(this)).removeClass('selected');
        $(this).toggleClass('selected');
        var hasSelection = ModalMediaLibrary.find('.js-select-image.selected');

        if (hasSelection.length > 0) {
          acceptBtn.removeAttr('disabled').removeClass('disabled');
          acceptBtn.attr({
            'data-selection': $data
          });
          formUpdateMediaLibrary.attr({
            'action': $(this).attr('data-action')
          });
          showAndClearFieldsUpdate(informations, false, formUpdateMediaLibrary);
        } else {
          acceptBtn.attr({
            'disabled': 'disabled'
          });
          acceptBtn.removeAttr('data-selection');
          acceptBtn.addClass('disabled');
          formUpdateMediaLibrary.removeAttr('action');
          showAndClearFieldsUpdate(informations, true, formUpdateMediaLibrary);
        }
      } else {//@todo
      }
    });
    ModalMediaLibrary.on('click', '.close', function (e) {
      var sel = ModalMediaLibrary.find('.js-select-image.selected');
      sel.trigger('click');
    });
    ModalMediaLibrary.on('blur', '.form-control', function (e) {
      if (formUpdateMediaLibrary.get(0).hasAttribute('action') === false) {
        return false;
      }

      var datas = formUpdateMediaLibrary.serializeFormJSON();
      $.ajax({
        method: 'POST',
        url: formUpdateMediaLibrary.attr('action'),
        data: datas,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function success(data) {
          //console.log(data)
          $('.js-select-image[data-id="' + data.media.id + '"]').attr({
            'data-informations': JSON.stringify(data.media)
          });
        },
        error: function error(err) {
          console.log('whoops', err);
        }
      });
    });

    if (el.autoremove != null && el.autoremove) {
      cibledInput.off();
      ModalMediaLibrary.on('hidden.bs.modal', function (e) {
        ModalMediaLibrary.off();
        mediaLibrary_container.off();
        formUpdateMediaLibrary.off();
        btnCallModal.off();
        $(this).remove();
      });
    }

    if (cibledInput.val() > 0) {
      var selected = ModalMediaLibrary.find('.js-select-image[data-id="' + cibledInput.val() + '"]');
      console.log(selected);
      selected.trigger('click');
      ModalMediaLibrary.find('.js-accept').trigger('click'); // GenerateSelection(mediaLibrary_container, ModalMediaLibrary, [ cibledInput.val() ]);
    }

    btnCallModal.on('click', function (e) {
      e.preventDefault();
      console.log('');

      if (el.callBy && el.callBy == 'ajax') {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: 'GET',
          url: Route('modale.getModale', {
            name: 'modaleMediaLibrary'
          }),
          success: function success(data) {
            console.log('data', data);
            $('body').append(data.html);
            ModalMediaLibrary = $('#modalMediaLibrary');
            formUpdateMediaLibrary = ModalMediaLibrary.find('form');
            formUpdateMediaLibrary.removeAttr('action');
            ModalMediaLibrary.modal('show');
          },
          error: function error(err) {
            console.log('err', err);
          }
        });
      } else {
        formUpdateMediaLibrary.removeAttr('action');
        ModalMediaLibrary.modal('show');
      }
    });
    TriggerDropZone.on('click', function (e) {
      e.preventDefault();
      $(DropzoneElm).trigger('click');
    });
  });
}

/***/ }),

/***/ "./resources/js/extensions/quillEditorField.js":
/*!*****************************************************!*\
  !*** ./resources/js/extensions/quillEditorField.js ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return QuillEditorInititalization; });
function QuillEditorInititalization(fields) {
  var modalMediaLibrary = $('#modalMediaLibrary');
  $.each(fields, function (i, el) {
    var quill = new Quill(el.selector + ' .editor', el.options);
    var hiddenField = $(el.selector).find('input[type="hidden"]');

    function UpdateHiddenField(el, delta) {
      el.val(JSON.stringify(delta));
    }

    if (hiddenField.val().length > 0) {
      quill.setContents(JSON.parse(hiddenField.val()));
    } else {
      UpdateHiddenField(hiddenField, quill.getContents());
    }

    quill.getModule('toolbar').addHandler('image', function () {
      modalMediaLibrary.addClass('from-quill').modal('show');
    });
    modalMediaLibrary.on('makequillcontent', function (event, el) {
      var range = quill.getSelection();
      modalMediaLibrary.removeClass('from-quill');
      quill.insertEmbed(range.index, 'image', $(el).find('img').attr('src'));
      $(el).trigger('click');
    });
    quill.on('text-change', function () {
      var delta = quill.getContents();
      UpdateHiddenField(hiddenField, quill.getContents());
    });
  });
}

/***/ }),

/***/ "./resources/js/extensions/select2Field.js":
/*!*************************************************!*\
  !*** ./resources/js/extensions/select2Field.js ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return select2Inititalization; });
function select2Inititalization(fields) {
  $.each(fields, function (i, el) {
    var select2boxe = $(el.selector + '> .form-group > select');
    console.log('select2boxe', select2boxe);

    if (el.withCreate) {
      var btnCallModal = $(el.selector + ' .js-handle-form-create');
      var ModaleCreatedCat = $(el.modal_id);
      var ModaleForm = ModaleCreatedCat.find('form');
      btnCallModal.on('click', function (e) {
        e.preventDefault();

        if (ModaleCreatedCat.length > 0) {
          ModaleCreatedCat.modal('show');
        }
      });
      ModaleForm.on('click', '[type="submit"]', function (e) {
        e.preventDefault();
        var datas = ModaleForm.serializeFormJSON();

        if (!datas.parent_id) {
          datas.parent_id = 0;
        }

        console.log(datas);
        $.ajax({
          method: ModaleForm.attr('method'),
          url: ModaleForm.attr('action'),
          data: datas,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function success(data) {
            console.log(data);
            $(ModaleForm).find('[name]').not('[name="_token"]').setResponseFromAjax();
            $(ModaleForm).clearValues();

            if (el.multilang == 1) {
              var newOption = new Option(data.category.title[el.currentLang], data.category.id, false, true);
            } else {
              var newOption = new Option(data.category.title, data.category.id, false, true);
            }

            select2boxe.append(newOption).trigger('change');
            ModaleCreatedCat.modal('hide'); // select2boxe.select2('open');
          },
          error: function error(err) {
            console.log('whoops', err);
            $(ModaleForm).find('[name]').not('[name="_token"]').setResponseFromAjax(err.responseJSON);
          }
        });
      });
    }

    select2boxe.select2(el.options);
  });
}

/***/ }),

/***/ 2:
/*!***********************************************!*\
  !*** multi ./resources/js/extensions-call.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/Ludow/Documents/projets-externes/pixelizer/resources/js/extensions-call.js */"./resources/js/extensions-call.js");


/***/ })

/******/ });