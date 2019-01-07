/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2008 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * Hebrew language file.
 */

var FCKLang =
{
// Language direction : "ltr" (left to right) or "rtl" (right to left).
Dir					: "rtl",

ToolbarCollapse		: "כיווץ סרגל הכלים",
ToolbarExpand		: "פתיחת סרגל הכלים",

// Toolbar Items and Context Menu
Save				: "שמירה",
NewPage				: "דף חדש",
Preview				: "תצוגה מקדימה",
Cut					: "גזירה",
Copy				: "העתקה",
Paste				: "הדבקה",
PasteText			: "הדבקה כטקסט פשוט",
PasteWord			: "הדבקה מ-וורד",
Print				: "הדפסה",
SelectAll			: "בחירת הכל",
RemoveFormat		: "הסרת העיצוב",
InsertLinkLbl		: "קישור",
InsertLink			: "הוספת/עריכת קישור",
RemoveLink			: "הסרת הקישור",
VisitLink			: "פתח קישור",
Anchor				: "הוספת/עריכת נקודת עיגון",
AnchorDelete		: "הסר נקודת עיגון",
InsertImageLbl		: "תמונה",
InsertImage			: "הוספת/עריכת תמונה",
InsertFlashLbl		: "פלאש",
InsertFlash			: "הוסף/ערוך פלאש",
InsertTableLbl		: "טבלה",
InsertTable			: "הוספת/עריכת טבלה",
InsertLineLbl		: "קו",
InsertLine			: "הוספת קו אופקי",
InsertSpecialCharLbl: "תו מיוחד",
InsertSpecialChar	: "הוספת תו מיוחד",
InsertSmileyLbl		: "סמיילי",
InsertSmiley		: "הוספת סמיילי",
About				: "אודות FCKeditor",
Bold				: "מודגש",
Italic				: "נטוי",
Underline			: "קו תחתון",
StrikeThrough		: "כתיב מחוק",
Subscript			: "כתיב תחתון",
Superscript			: "כתיב עליון",
LeftJustify			: "יישור לשמאל",
CenterJustify		: "מרכוז",
RightJustify		: "יישור לימין",
BlockJustify		: "יישור לשוליים",
DecreaseIndent		: "הקטנת אינדנטציה",
IncreaseIndent		: "הגדלת אינדנטציה",
Blockquote			: "בלוק ציטוט",
CreateDiv			: "צור מיכל(תג)DIV",
EditDiv				: "ערוך מיכל (תג)DIV",
DeleteDiv			: "הסר מיכל(תג) DIV",
Undo				: "ביטול צעד אחרון",
Redo				: "חזרה על צעד אחרון",
NumberedListLbl		: "רשימה ממוספרת",
NumberedList		: "הוספת/הסרת רשימה ממוספרת",
BulletedListLbl		: "רשימת נקודות",
BulletedList		: "הוספת/הסרת רשימת נקודות",
ShowTableBorders	: "הצגת מסגרת הטבלה",
ShowDetails			: "הצגת פרטים",
Style				: "סגנון",
FontFormat			: "עיצוב",
Font				: "גופן",
FontSize			: "גודל",
TextColor			: "צבע טקסט",
BGColor				: "צבע רקע",
Source				: "מקור",
Find				: "חיפוש",
Replace				: "החלפה",
SpellCheck			: "בדיקת איות",
UniversalKeyboard	: "מקלדת אוניברסלית",
PageBreakLbl		: "שבירת דף",
PageBreak			: "הוסף שבירת דף",

Form			: "טופס",
Checkbox		: "תיבת סימון",
RadioButton		: "לחצן אפשרויות",
TextField		: "שדה טקסט",
Textarea		: "איזור טקסט",
HiddenField		: "שדה חבוי",
Button			: "כפתור",
SelectionField	: "שדה בחירה",
ImageButton		: "כפתור תמונה",

FitWindow		: "הגדל את גודל העורך",
ShowBlocks		: "הצג בלוקים",

// Context Menu
EditLink			: "עריכת קישור",
CellCM				: "תא",
RowCM				: "שורה",
ColumnCM			: "עמודה",
InsertRowAfter		: "הוסף שורה אחרי",
InsertRowBefore		: "הוסף שורה לפני",
DeleteRows			: "מחיקת שורות",
InsertColumnAfter	: "הוסף עמודה אחרי",
InsertColumnBefore	: "הוסף עמודה לפני",
DeleteColumns		: "מחיקת עמודות",
InsertCellAfter		: "הוסף תא אחרי",
InsertCellBefore	: "הוסף תא אחרי",
DeleteCells			: "מחיקת תאים",
MergeCells			: "מיזוג תאים",
MergeRight			: "מזג ימינה",
MergeDown			: "מזג למטה",
HorizontalSplitCell	: "פצל תא אופקית",
VerticalSplitCell	: "פצל תא אנכית",
TableDelete			: "מחק טבלה",
CellProperties		: "תכונות התא",
TableProperties		: "תכונות הטבלה",
ImageProperties		: "תכונות התמונה",
FlashProperties		: "מאפייני פלאש",

AnchorProp			: "מאפייני נקודת עיגון",
ButtonProp			: "מאפייני כפתור",
CheckboxProp		: "מאפייני תיבת סימון",
HiddenFieldProp		: "מאפיני שדה חבוי",
RadioButtonProp		: "מאפייני לחצן אפשרויות",
ImageButtonProp		: "מאפיני כפתור תמונה",
TextFieldProp		: "מאפייני שדה טקסט",
SelectionFieldProp	: "מאפייני שדה בחירה",
TextareaProp		: "מאפיני איזור טקסט",
FormProp			: "מאפיני טופס",

FontFormats			: "נורמלי;קוד;כתובת;כותרת;כותרת 2;כותרת 3;כותרת 4;כותרת 5;כותרת 6",

// Alerts and Messages
ProcessingXHTML		: "מעבד XHTML, נא להמתין...",
Done				: "המשימה הושלמה",
PasteWordConfirm	: "נראה הטקסט שבכוונתך להדביק מקורו בקובץ וורד. האם ברצונך לנקות אותו טרם ההדבקה?",
NotCompatiblePaste	: "פעולה זו זמינה לדפדפן אינטרנט אקספלורר מגירסא 5.5 ומעלה. האם להמשיך בהדבקה ללא הניקוי?",
UnknownToolbarItem	: "פריט לא ידוע בסרגל הכלים \"%1\"",
UnknownCommand		: "שם פעולה לא ידוע \"%1\"",
NotImplemented		: "הפקודה לא מיושמת",
UnknownToolbarSet	: "ערכת סרגל הכלים \"%1\" לא קיימת",
NoActiveX			: "הגדרות אבטחה של הדפדפן עלולות לגביל את אפשרויות העריכה.יש לאפשר את האופציה \"הרץ פקדים פעילים ותוספות\". תוכל לחוות טעויות וחיווים של אפשרויות שחסרים.",
BrowseServerBlocked : "לא ניתן לגשת לדפדפן משאבים.אנא וודא שחוסם חלונות הקופצים לא פעיל.",
DialogBlocked		: "לא היה ניתן לפתוח חלון דיאלוג. אנא וודא שחוסם חלונות קופצים לא פעיל.",
VisitLinkBlocked	: "לא ניתן לפתוח חלון חדש.נא לוודא שחוסמי החלונות הקופצים לא פעילים.",

// Dialogs
DlgBtnOK			: "אישור",
DlgBtnCancel		: "ביטול",
DlgBtnClose			: "סגירה",
DlgBtnBrowseServer	: "סייר השרת",
DlgAdvancedTag		: "אפשרויות מתקדמות",
DlgOpOther			: "<אחר>",
DlgInfoTab			: "מידע",
DlgAlertUrl			: "אנא הזן URL",

// General Dialogs Labels
DlgGenNotSet		: "<לא נקבע>",
DlgGenId			: "זיהוי (Id)",
DlgGenLangDir		: "כיוון שפה",
DlgGenLangDirLtr	: "שמאל לימין (LTR)",
DlgGenLangDirRtl	: "ימין לשמאל (RTL)",
DlgGenLangCode		: "קוד שפה",
DlgGenAccessKey		: "מקש גישה",
DlgGenName			: "שם",
DlgGenTabIndex		: "מספר טאב",
DlgGenLongDescr		: "קישור לתיאור מפורט",
DlgGenClass			: "גיליונות עיצוב קבוצות",
DlgGenTitle			: "כותרת מוצעת",
DlgGenContType		: "Content Type מוצע",
DlgGenLinkCharset	: "קידוד המשאב המקושר",
DlgGenStyle			: "סגנון",

// Image Dialog
DlgImgTitle			: "תכונות התמונה",
DlgImgInfoTab		: "מידע על התמונה",
DlgImgBtnUpload		: "שליחה לשרת",
DlgImgURL			: "כתובת (URL)",
DlgImgUpload		: "העלאה",
DlgImgAlt			: "טקסט חלופי",
DlgImgWidth			: "רוחב",
DlgImgHeight		: "גובה",
DlgImgLockRatio		: "נעילת היחס",
DlgBtnResetSize		: "איפוס הגודל",
DlgImgBorder		: "מסגרת",
DlgImgHSpace		: "מרווח אופקי",
DlgImgVSpace		: "מרווח אנכי",
DlgImgAlign			: "יישור",
DlgImgAlignLeft		: "לשמאל",
DlgImgAlignAbsBottom: "לתחתית האבסולוטית",
DlgImgAlignAbsMiddle: "מרכוז אבסולוטי",
DlgImgAlignBaseline	: "לקו התחתית