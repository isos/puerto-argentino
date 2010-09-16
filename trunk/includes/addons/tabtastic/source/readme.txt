Tabtastic Notes:

1.0 OVERVIEW

This library is a simple way to implement tabs on your page using CSS, a little JS, and semantic markup which degrades gracefully on browsers with CSS unavailable or disabled.

Not only is it easy to use and accessible for screen-readers, but it supports multiple (nested, even) tabsets on the same page and allows users to bookmark the page loading to a specific tab.

Here's some sample markup:


<ul class="tabset_tabs">
   <li><a href="#tab1" class="active">Tab 1</a></li>
   <li><a href="#tab2">Tab 2</a></li>
   <li><a href="#tab3">Tab 3</a></li>
</ul>

<div id="tab1" class="tabset_content">
   <h2 class="tabset_label">Tab 1</h2>
   Tab 1 Content
</div>

<div id="tab2" class="tabset_content">
   <h2 class="tabset_label">Tab 2</h2>
   Tab 2 Content
</div>

<div id="tab3" class="tabset_content">
   <h2 class="tabset_label">Tab 3</h2>
   Tab 3 Content
</div>
	It's that easy! (As long as you include the files listed in the Requirements section.)

2.0 REQUIREMENTS

This library has been tested to work with Safari 1.2, IE 5.5, Mozilla 1.4, Netscape 7, and Firefox 0.8. It works almost perfectly in Mozilla 0.9 and NS6, and degrades gracefully in IE5Mac and Opera. It should work with any modern, standards-compliant browser. (IE5Mac and Opera7 support are possible; read the last bullet in the Notes section.)

In addition to markup as shown in the Overview, you need to include some other files for this to work automagically.

Specifically, you need to copy one CSS file (tabtastic.css), one JS file (tabtastic.js), and three JS library files (AttachEvent.js, AddClassKillClass.js, AddCSS.js).

The head of your HTML page should look something like this:

<script type="text/javascript" src="addclasskillclass.js"></script>
<script type="text/javascript" src="attachevent.js"></script>
<script type="text/javascript" src="AddCSS.js"></script>
<script type="text/javascript" src="tabtastic.js"></script>

3.0 STEP BY STEP

Step-by-step instructions for building your own tabset:

3.1 Copy the five files listed in the Requirements section to your server.

3.2 Assuming the files you copied are in the same directory as the HTML file you're putting the tabs in, put this code in the <head> of your document:

<script type="text/javascript" src="addclasskillclass.js"></script>
<script type="text/javascript" src="attachevent.js"></script>
<script type="text/javascript" src="AddCSS.js"></script>
<script type="text/javascript" src="tabtastic.js"></script>

3.3 Create a <ul> with class="tabset_tabs". For each tab, create code like this: 
<li><a href="#tabid">Tab Title</a></li>

3.4 (optional) If you want one tab to start out as the 'active' tab, put class="active" in the <a> for that tab. 

3.5 For each tab, create content like this:

<div id="tabid" class="tabset_content">
   <h2 class="tabset_label">Tab Title</h2>
   ...
</div>(The <h2> will not display, but is important for accessibility.)

3.6 (optional) Add your own additional custom CSS rules to change the colors which are used. (See Notes.)

4.0 NOTES

A few random tips and limitations:

4.1 The only bug present in NS6/Mozilla 1.2 (and earlier) is that the selected tab does not overlap the content, causing there to be a black line drawn between the selected tab and the content.

4.2 There should be no whitespace (other than in tab titles) within your <ul class="tabset_tabs">...</ul>, if you want your tabs to mash up against each other (as they do in this document). 

4.3 The following CSS selectors will give you control over the styling of the content: 
.tabset_tabs a             { /* A normal tab                             */ }
.tabset_tabs a:hover       { /* A normal tab, when hovered over          */ }
.tabset_tabs a.active      { /* The selected tab                         */ }
.tabset_tabs a.preActive   { /* The tab to the left of the selected tab  */ }
.tabset_tabs a.postActive  { /* The tab to the right of the selected tab */ }
.tabset_content            { /* The selected tab's contents              */ }Note that you may need to use the ! important rule to force your styles to take effect. 

4.4 Google's translation service does not seem to play nicely with the library; none of the content shows up, only the tabs themselves. For example, see this document translated. 

4.5 It's easy to make the content areas of each tab have scrollbars. Simply add a CSS rule like this .tabset_content { height:20em; overflow:auto } and scrollbars will appear as needed! 

4.6 This library uses JS to include the CSS file, so that the content is NOT hidden/inaccessible if the user has JS disabled.

Unfortunately, this breaks IE5Mac and Opera7. If you need support for them (at the expense of users who have CSS supported but JS disabled), comment out AddStyleSheet('tabtastic.css',0) at the end of tabtastic.js, and link in the CSS file yourself.


