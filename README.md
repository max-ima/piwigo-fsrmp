# fsrmp for Piwigo - filter system recently modified pictures

* Internal name: `fsrmp` (directory name in `plugins/`)
* Plugin page: http://piwigo.org/ext/extension_view.php?eid=870

When some pictures are updated by another application in some sparse categories, it can be useful to perform tasks on them with batch manager. This plugin provides up to three new filters to grab recently modified picture files on the operating system.
* These filters are tunable. 
* Are enabled only those checked in the configuration page.

**Example:** assume, once in a while, you are adding some tags to you pictures with jBrout software (or digikam, ...). If your tags are stored within the picture, tagging is modifying your file. You will be happy PIWIGO to get these pictures metadata quickly up to date.

**NB:** you can also add tags to a representatives picture. The represented file will be listed in the batch manager. For instance a video.
