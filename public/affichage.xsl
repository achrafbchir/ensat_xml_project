<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:xs="http://www.w3.org/2001/XMLSchema"
    exclude-result-prefixes="xs"
    version="2.0">
    <xsl:template match="Ginf3_Notes.xml">
        <html>
            <body>
                <table border="1">
                    <tr bgcolor="#9acd32">
                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>ClassName</th>
                        <th>ModuleName</th>
                        <th>ElementName</th>
                        <th>NoteElement</th>
                    </tr>
                    <xsl:for-each select="notes/note">
                        <tr>
                            <td><xsl:value-of select="FirstName"/></td>
                            <td><xsl:value-of select="LastName"/></td>
                            <td><xsl:value-of select="ClassName"/></td>
                            <td><xsl:value-of select="ModuleName"/></td>
                            <td><xsl:value-of select="ElementName"/></td>
                            <xsl:if test="NoteElement &lt; 8">
                                <td bgcolor="#F00"><xsl:value-of select="NoteElement"/></td>
                            </xsl:if>
                            <xsl:if test="NoteElement &gt;= 8 and NoteElement &lt; 12">
                                <td bgcolor="#FFA500"><xsl:value-of select="NoteElement"/></td>
                            </xsl:if>
                            <xsl:if test="NoteElement &gt;= 12">
                                <td bgcolor="#080"><xsl:value-of select="NoteElement"/></td>
                            </xsl:if>
                        </tr>
                    </xsl:for-each>
                </table>
                <h2>La list des étudiants convoqué pour le rattrapage</h2>
                <table border="1">
                    <tr bgcolor="#9acd32">
                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>ClassName</th>
                        <th>ModuleName</th>
                        <th>ElementName</th>
                    </tr>
                    <xsl:for-each select="notes/note">
                        <tr>
                            <xsl:if test="NoteElement &lt; 8">
                                <td><xsl:value-of select="FirstName"/></td>
                                <td><xsl:value-of select="LastName"/></td>
                                <td><xsl:value-of select="ClassName"/></td>
                                <td><xsl:value-of select="ModuleName"/></td>
                                <td><xsl:value-of select="ElementName"/></td>
                            </xsl:if>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>