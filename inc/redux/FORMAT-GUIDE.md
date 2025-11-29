# Redux Fields Format Guide

This guide explains how to format textarea fields in Redux options panel.

## Risks Section (risks_items)

**Format:** `Title | Description` (one item per line)

**Example:**
```
انسداد متكرر | يعطّل خطوط الإنتاج ويوقف العمل.
تآكل سريع | يؤدي إلى تسرّب الروائح والمياه وتلوث البيئة.
نمو بكتيري | بسبب استخدام خامات رديئة غير مقاومة للميكروبات.
```

## Sectors Section (sectors_items)

**Format:** `Title | Description | Icon` (one item per line)

**Icon Options:** `residential`, `industrial`, `hospitality`

**Example:**
```
القطاع السكني | حلول للصرف المنزلي، مصائد شحوم للمطابخ، وأنظمة ري ذكية. | residential
القطاع الصناعي | جريلات تتحمل الأوزان الثقيلة، ومعالجة المياه الصناعية المعقدة. | industrial
المطاعم والفنادق | أنظمة صحية تمنع الروائح والقوارض وتوافق اشتراطات السلامة الغذائية. | hospitality
```

## Stainless Steel Section (stainless_items)

**Format:** One feature per line (simple text)

**Example:**
```
مقاومة عالية للتآكل في البيئات الرطبة.
عمر افتراضي طويل وصيانة شبه معدومة.
يمنع تراكم البكتيريا وسهل التنظيف.
```

## Tips

- Use `|` (pipe) to separate fields in Risks and Sectors
- Each line represents one item
- Empty lines are ignored
- Leading/trailing spaces are automatically trimmed


